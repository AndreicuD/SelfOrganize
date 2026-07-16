<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use app\models\User;
use app\models\ExchangeRate;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id [int(11) unsigned (auto increment)]
 * @property integer $user_id [int(11) unsigned]
 * @property string $name [varchar(100)]
 * @property string $currency [varchar(3)]
 * @property string $type [enum]
 * @property string $balance [decimal(15,2) unsigned]
 * @property integer $is_active [tinyint(1)]
 * @property integer $created_at [datetime]
 * @property integer $updated_at [timestamp = current_timestamp()]
 *
 * @property User $user
 * 
 */
class Account extends ActiveRecord
{
    public static function tableName()
    {
        return 'account';
    }

    public function rules()
    {
        return [
            [['user_id', 'name', 'currency', 'type'], 'required'],
            [['balance'], 'number', 'min' => 0],
            [['name'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 3],
            [['type'], 'in', 'range' => array_keys(self::typeList())],
            [['is_active'], 'boolean'],
            [['user_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name'     => Yii::t('app', 'Account Name'),
            'currency' => Yii::t('app', 'Currency'),
            'balance'  => Yii::t('app', 'Balance'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public static function typeList(): array
    {
        return [
            'checking' => Yii::t('app', 'Checking'),
            'savings' => Yii::t('app', 'Savings'),
            'cash' => Yii::t('app', 'Cash'),
            'investments' => Yii::t('app', 'Investments'),
            'other' => Yii::t('app', 'Other'),
        ];
    }

    public static function currencyList(): array
    {
        return [
            'RON' => 'RON — Romanian Leu',
            'EUR' => 'EUR — Euro',
            'USD' => 'USD — US Dollar',
            'GBP' => 'GBP — British Pound',
            'CHF' => 'CHF — Swiss Franc',
            'JPY' => 'JPY — Japanese Yen',
            'CAD' => 'CAD — Canadian Dollar',
            'AUD' => 'AUD — Australian Dollar',
            'SEK' => 'SEK — Swedish Krona',
            'NOK' => 'NOK — Norwegian Krone',
            'DKK' => 'DKK — Danish Krone',
            'PLN' => 'PLN — Polish Złoty',
            'HUF' => 'HUF — Hungarian Forint',
            'CZK' => 'CZK — Czech Koruna',
            'BGN' => 'BGN — Bulgarian Lev',
        ];
    }

    // Reverse lookup: 'Romanian Leu' from 'RON'
    public static function currencyName(string $code): string
    {
        $list = self::currencyList();
        if (isset($list[$code])) {
            // extract just the name part after the dash
            return trim(explode('—', $list[$code])[1]);
        }
        return $code; // fallback to code if not found
    }

    /**
     * Get total balance in preferred currency for a certain User by id
     * @param int $userId
     * @return float
     */
    public static function getTotalBalance(int $userId): float
    {
        $accounts  = self::getByUser($userId);
        $preferred = User::findOne($userId)->preferred_currency ?? 'RON';
        $total     = 0.0;

        foreach ($accounts as $account) {
            $total += ExchangeRate::convert(
                (float) $account->balance,
                $account->currency,
                $preferred
            );
        }

        return round($total, 2);
    }

    /**
     * Get all accounts of User by id
     * @param int $userId
     * @return Account[]
     */
    public static function getByUser(int $userId): array
    {
        return self::find()
            ->where(['user_id' => $userId, 'is_active' => 1])
            ->orderBy(['type' => SORT_ASC])
            ->all();
    }


    /**
     * Get balance history in the last %days time
     * <br>
     * !!! getBalanceHistory is a running total - each day carries forward from the previous
     * @param int $userId
     * @param int $days
     * @return array{amount: float, date: string[]}
     */
    public static function getBalanceHistory(int $userId, int $days): array
    {
        $preferred  = \Yii::$app->user->identity->preferred_currency ?? 'RON';
        $startDate  = date('Y-m-d', strtotime("-{$days} days"));

        // Calculate total balance before the window by working backwards
        // Current balance minus all transactions after startDate
        $runningBalance = 0.0;
        $accounts = self::getByUser($userId);
        // Get active account IDs for this user
        $activeAccountIds = array_map(fn($acc) => $acc->id, $accounts);

        foreach ($accounts as $acc) {
            // Sum of transactions after the window start
            $afterWindow = (float) Transaction::find()
                ->where(['account_id' => $acc->id])
                ->andWhere(['>=', 'transaction_date', $startDate])
                ->sum("CASE WHEN type IN ('income','transfer_in') THEN amount ELSE -amount END");

            // Balance before window = current balance minus what happened after
            $balanceBeforeWindow = (float)$acc->balance - $afterWindow;

            $runningBalance += ExchangeRate::convert(
                $balanceBeforeWindow,
                $acc->currency,
                $preferred
            );
        }

        // Get transactions in window — filter to active accounts only
        $transactions = Transaction::find()
            ->where(['user_id' => $userId])
            ->andWhere(['account_id' => $activeAccountIds])
            ->andWhere(['>=', 'transaction_date', $startDate])
            ->orderBy(['transaction_date' => SORT_ASC])
            ->all();

        // Build day-by-day running total
        $history = [];
        $current = strtotime($startDate);
        $end     = strtotime('today');

        while ($current <= $end) {
            $dayStr = date('Y-m-d', $current);

            foreach ($transactions as $t) {
                if (substr($t->transaction_date, 0, 10) === $dayStr) {
                    $delta = $t->isCredit() ? (float)$t->amount : -(float)$t->amount;
                    $runningBalance += ExchangeRate::convert(
                        $delta,
                        $t->currency,
                        $preferred
                    );
                }
            }

            $history[] = [
                'date'   => date('d M', $current),
                'amount' => round($runningBalance, 2),
            ];

            $current = strtotime('+1 day', $current);
        }

        //die(json_encode($history));
        return $history;
    }

    /**
     * Get balance history by transactions for each day
     * <br>
     * !!! getDailyTotal is a daily sum - each day is independent, starts from zero
     * @param int $userId
     * @param int $days
     * @param string $type
     * @return void
     */
    public static function getDailyTotals(int $userId, int $days, string $type): array
    {
        $preferred  = \Yii::$app->user->identity->preferred_currency ?? 'RON';
        $startDate  = date('Y-m-d', strtotime("-{$days} days"));
        $activeAccountIds = array_map(
            fn($acc) => $acc->id, 
            self::getByUser($userId)
        );

        $transactions = Transaction::find()
            ->where(['user_id' => $userId, 'type' => $type])
            ->andWhere(['account_id' => $activeAccountIds])
            ->andWhere(['>=', 'transaction_date', $startDate])
            ->orderBy(['transaction_date' => SORT_ASC])
            ->all();

        // Build day-by-day totals
        $history = [];
        $current = strtotime($startDate);
        $end     = strtotime('today');

        while ($current <= $end) {
            $dayStr = date('Y-m-d', $current);
            $dayTotal = 0.0;

            foreach ($transactions as $t) {
                if (substr($t->transaction_date, 0, 10) === $dayStr) {
                    $account  = Account::findOne($t->account_id);
                    $dayTotal += ExchangeRate::convert(
                        (float)$t->amount,
                        $t->currency,
                        $preferred
                    );
                }
            }

            $history[] = [
                'date'   => date('d M', $current),
                'amount' => round($dayTotal, 2),
            ];

            $current = strtotime('+1 day', $current);
        }

        return $history;
    }

    /**
     * Get monthly stats of income, expense and transfers
     * @param int $userId
     * @return array{expense: float, income: float, transfers: float}
     */
    public static function getMonthlyStats(int $userId): array
    {
        $preferred    = \Yii::$app->user->identity->preferred_currency ?? 'RON';
        $startOfMonth = date('Y-m-01');
        $activeIds    = array_map(fn($a) => $a->id, self::getByUser($userId));

        $sum = function(string $type) use ($userId, $activeIds, $startOfMonth, $preferred) {
            $transactions = Transaction::find()
                ->where(['user_id' => $userId, 'type' => $type])
                ->andWhere(['account_id' => $activeIds])
                ->andWhere(['>=', 'transaction_date', $startOfMonth])
                ->all();

            $total = 0.0;
            foreach ($transactions as $t) {
                $total += ExchangeRate::convert((float)$t->amount, $t->currency, $preferred);
            }
            return round($total, 2);
        };

        return [
            'income'    => $sum('income'),
            'expense'   => $sum('expense'),
            'transfers' => $sum('transfer_out'),
        ];
    }
}