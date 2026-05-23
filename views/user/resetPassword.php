<?php
/** @var yii\web\View $this */
/** @var app\models\ResetPasswordForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'New Password');
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card col-card">
            <div class="card-body p-4 p-lg-5">

                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'New Password') ?></h1>
                    <p class="text-body-secondary small">
                        <?= Yii::t('app', 'Choose a new password for your account.') ?>
                    </p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id'     => 'reset-password-form',
                    'action' => ['user/reset-password', 'token' => Yii::$app->request->get('token')],
                ]); ?>

                    <div class="mb-4">
                        <?= $form->field($model, 'password', [
                            'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                            </span>{input}{error}</div>',
                        ])->passwordInput([
                            'class'       => 'form-control',
                            'placeholder' => Yii::t('app', 'New password'),
                            'autofocus'   => true,
                        ])->label(Yii::t('app', 'New Password')) ?>
                    </div>

                    <div class="d-grid">
                        <?= Html::submitButton(Yii::t('app', 'Save New Password'), [
                            'class' => 'btn btn-primary btn-lg rounded-3 text-white',
                        ]) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>