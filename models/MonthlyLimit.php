<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * @property string $id [int(11)]
 * @property string $user_id [int(11)]
 * @property string $budget_limit [int(11)]
 * @property integer $created_at [datetime]
 * @property integer $updated_at [timestamp = current_timestamp()]
 */
class MonthlyLimit extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'monthly_limits';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'budget_limit'], 'required'],
            [['budget_limit'], 'number', 'min' => 0],
            [['id', 'user_id', 'budget_limit'], 'safe'],
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

    /**
     * Get monthly budget limit by user id
     * @param int $userId
     * @return int
     */
    public static function getByUser(int $userId): ?MonthlyLimit
    {
        return MonthlyLimit::find()
            ->where(['user_id' => $userId])
            ->one();
    }
}