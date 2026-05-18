<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

use app\models\User;
use app\models\Account;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string  $type [income, expense, transfer_in, transfer_out]
 * @property string  $amount [decimal(15,2)]
 * @property string  $currency [varchar(3)]
 * @property string  $note [varchar(256)]
 * @property integer $related_transaction_id
 * @property string  $created_at
 * @property string  $updated_at
 *
 * @property Account $account
 * @property User    $user
 * @property Transaction $relatedTransaction
 */
class Transaction extends ActiveRecord
{
    public $to_account_id;

    const TYPE_INCOME       = 'income';
    const TYPE_EXPENSE      = 'expense';
    const TYPE_TRANSFER_IN  = 'transfer_in';
    const TYPE_TRANSFER_OUT = 'transfer_out';

    public static function tableName(): string
    {
        return 'transaction';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'account_id', 'type', 'amount'], 'required'],
            [['amount'], 'number', 'min' => 0.01],
            [['currency'], 'string', 'max' => 3],
            [['note'], 'string', 'max' => 256],
            [['user_id', 'account_id', 'related_transaction_id'], 'integer'],
            [['type'], 'in', 'range' => [
                self::TYPE_INCOME,
                self::TYPE_EXPENSE,
                self::TYPE_TRANSFER_IN,
                self::TYPE_TRANSFER_OUT,
            ]],
            [['to_account_id'], 'integer'],
            [['to_account_id'], 'required', 'when' => function($model) {
                return in_array($model->type, ['transfer_out', 'transfer_in']);
            }],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'account_id' => Yii::t('app', 'Account'),
            'type'       => Yii::t('app', 'Type'),
            'amount'     => Yii::t('app', 'Amount'),
            'currency'   => Yii::t('app', 'Currency'),
            'note'       => Yii::t('app', 'Note'),
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class'              => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value'              => new Expression('NOW()'),
            ],
        ];
    }

    // --- Relations ---

    public function getAccount(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    public function getUser(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRelatedTransaction(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Transaction::class, ['id' => 'related_transaction_id']);
    }

    // --- Helpers ---

    public static function typeList(): array
    {
        return [
            self::TYPE_INCOME       => Yii::t('app', 'Income'),
            self::TYPE_EXPENSE      => Yii::t('app', 'Expense'),
            self::TYPE_TRANSFER_IN  => Yii::t('app', 'Transfer In'),
            self::TYPE_TRANSFER_OUT => Yii::t('app', 'Transfer Out'),
        ];
    }

    public function isCredit(): bool
    {
        return in_array($this->type, [self::TYPE_INCOME, self::TYPE_TRANSFER_IN]);
    }

    public function isDebit(): bool
    {
        return in_array($this->type, [self::TYPE_EXPENSE, self::TYPE_TRANSFER_OUT]);
    }

    public static function getByUser(int $userId, int $limit = 10): array
    {
        return self::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getByAccount(int $accountId, int $limit = 10): array
    {
        return self::find()
            ->where(['account_id' => $accountId])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}