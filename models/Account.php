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
}