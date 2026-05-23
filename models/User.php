<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
* User model 
* 
* @property integer $id [int(auto increment)]
* @property string $email [varchar(254)]
* @property string $username [varchar(254)]
*
* @property string $preferred_accent [varchar(254)]
* @property string $preferred_currency [varchar(254)]
*
* @property integer $status [smallint = 10]
* @property string $auth_key [varchar(32)]
* @property string $password_hash [varchar(254)]
* @property string $password_reset_token [varchar(254)]
* @property string $verification_token [varchar(254)]
* @property integer $created_at [datetime]
* @property integer $updated_at [timestamp = current_timestamp()]
*
* @property-read string $authKey
* @property string $password write-only password
*
* @property AuthAssignment $role
*/
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * @var \app\models\AuthAssignment
     */
    public $item_name;
    public $page_size;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email', 'username', 'password'], 'required', 'on' => 'create'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE, 'on' => 'default'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['item_name', 'default', 'value' => 'member', 'on' => 'create'],
            ['username', 'string', 'max' => 254],
            ['username', 'unique', 'on' => 'create'],
            ['username', 'unique', 'targetAttribute' => 'username', 'filter' => ['!=', 'id', Yii::$app->user->id]],
            ['email', 'required', 'on' => 'default'],
            ['email', 'email', 'on' => 'default'],
            ['email', 'email', 'on' => 'create'],
            ['email', 'unique', 'on' => 'default'],
            ['email', 'unique', 'on' => 'create'],
            ['password_confirmation', 'compare', 'compareAttribute' => 'new_password', 'on' => 'create'],
            [['auth_key', 'password_hash', 'password_reset_token', 'verification_token', 'password'], 'safe'],
            [['id', 'email', 'username', 'birth_date', 'item_name'], 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'password_confirmation' => Yii::t('app', 'Password confirmation'),
            'status' => Yii::t('app', 'Status'),
            'item_name' => Yii::t('app', 'Access level'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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

    public function afterFind(): void
    {
        $this->item_name = $this->getRoleName();
        parent::afterFind();
    }
    
    /**
     * Relation with AuthAssignment model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole(): \yii\db\ActiveQuery
    {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * Returns the role name ( item_name )
     *
     * @return string
     */
    public function getRoleName(): string
    {
        return $this->role->item_name ?? 'member';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): static|null
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int|string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): static|null
    {
        foreach (self::$_users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @return array the possible statuses
     */
    public static function statusesList(): array
    {
        return [
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
            self::STATUS_INACTIVE => Yii::t('app', 'Inactive'),
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
        ];
    }   

    /**
     * Creates data provider instance with search query applied
     * used to create lists / grids
     *
     * @param array $params
     * @param bool $full
     * @return ActiveDataProvider
     */
    public function search(array $params, bool $full = false): ActiveDataProvider
    {
        $this->scenario = 'search';

        $query = self::find();
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id'=>SORT_DESC],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            '{{%user}}.status' => $this->status,
            '{{%auth_assignment}}.item_name' => $this->item_name,
        ]);

        $query->andFilterWhere(['like', '{{%user}}.email', $this->email])
            ->andFilterWhere(['like', '{{%user}}.username', $this->username])
            ->andFilterWhere(['like', '{{%user}}.birth_date', $this->birth_date])
            ->andFilterWhere(['like', '{{%user}}.created_at', $this->created_at])
            ->andFilterWhere(['like', '{{%user}}.updated_at', $this->updated_at]);

        return $dataProvider;
    }

     /**
     * Finds username by id
     *
     * @param string $id
     * @return string|null
     */
    public static function getUsername($id): null|string
    {
        $object = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return $object ? $object->username : 'User not found';
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username): null|static
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritDoc}
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function generateAuthKey(): void
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string|null
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    // TAKEN FROM SKILLSWAP MIGHT NOT BE ENTIRELY CORRECT
    // TAKEN FROM SKILLSWAP MIGHT NOT BE ENTIRELY CORRECT
    // TAKEN FROM SKILLSWAP MIGHT NOT BE ENTIRELY CORRECT

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email): null|static
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token): null|static
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status'               => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) return false;

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'] ?? 86400;
        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token): null|static
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken(): void
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken(): void
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }
}
