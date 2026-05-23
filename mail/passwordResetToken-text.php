<?php
/** @var yii\web\View $this */
/** @var app\models\User $user */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Someone requested a password reset for your <?= Yii::$app->name ?> account.

Click the link below to reset your password (expires in 24 hours):
<?= $resetLink ?>

If you didn't request this, ignore this email.