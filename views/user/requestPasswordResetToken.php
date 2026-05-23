<?php
/** @var yii\web\View $this */
/** @var app\models\PasswordResetRequestForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Reset Password');
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card col-card">
            <div class="card-body p-4 p-lg-5">

                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Reset Password') ?></h1>
                    <p class="text-body-secondary small">
                        <?= Yii::t('app', 'Enter your email and we\'ll send you a reset link.') ?>
                    </p>
                </div>

                <?php $form = ActiveForm::begin([
                    'id'     => 'request-password-reset-form',
                    'action' => ['user/request-password-reset'],
                ]); ?>

                    <div class="mb-4">
                        <?= $form->field($model, 'email', [
                            'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>
                            </span>{input}{error}</div>',
                        ])->textInput([
                            'class'       => 'form-control',
                            'placeholder' => Yii::t('app', 'Your email address'),
                            'type'        => 'email',
                            'autofocus'   => true,
                        ]) ?>
                    </div>

                    <div class="d-grid mb-3">
                        <?= Html::submitButton(Yii::t('app', 'Send Reset Link'), [
                            'class' => 'btn btn-primary btn-lg rounded-3 text-white',
                        ]) ?>
                    </div>

                <?php ActiveForm::end(); ?>

                <p class="text-center text-body-secondary small mb-0">
                    <?= Html::a(Yii::t('app', '← Back to login'), ['user/login']) ?>
                </p>

            </div>
        </div>
    </div>
</div>