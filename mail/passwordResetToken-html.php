<?php
/** @var yii\web\View $this */
/** @var app\models\User $user */

use yii\helpers\Html;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>
<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto;">
    <h2>Hello, <?= Html::encode($user->username) ?></h2>
    <p>Someone requested a password reset for your account on <?= Yii::$app->name ?>.</p>
    <p>Click the button below to reset your password. This link expires in 24 hours.</p>
    <p style="text-align: center; margin: 2rem 0;">
        <a href="<?= $resetLink ?>" 
           style="background-color: #e91e63; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            Reset Password
        </a>
    </p>
    <p>If you didn't request this, ignore this email — your password won't change.</p>
    <p style="color: #888; font-size: 12px;">
        If the button doesn't work, copy this link:<br>
        <?= Html::encode($resetLink) ?>
    </p>
</div>