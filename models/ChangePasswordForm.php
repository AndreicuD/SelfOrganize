<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public string $current_password = '';
    public string $new_password     = '';
    public string $confirm_password = '';

    public function rules(): array
    {
        return [
            [['current_password', 'new_password', 'confirm_password'], 'required'],
            [['current_password', 'new_password', 'confirm_password'], 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Passwords do not match.'],
            ['current_password', 'validateCurrentPassword'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'current_password' => Yii::t('app', 'Current Password'),
            'new_password'     => Yii::t('app', 'New Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
        ];
    }

    public function validateCurrentPassword(string $attribute): void
    {
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'Current password is incorrect.'));
        }
    }

    public function changePassword(): bool
    {
        if (!$this->validate()) return false;

        $user = Yii::$app->user->identity;
        
        if (!$user) return false;
        
        $user->setPassword($this->new_password);
        //$user->generateAuthKey();

        return $user->save(false);
    }
}