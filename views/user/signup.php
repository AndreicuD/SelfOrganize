<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Create an account';
$this->params['meta_description'] = 'Create an account.';

$htmlIcon = <<<HTML
{label}<div class="input-group"><span class="input-group-text" aria-hidden="true">%s</span>{input}</div>{error}{hint}
HTML;
$labelOptions = ['class' => 'form-label fw-semibold small'];
?>

<div class="site-login d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 overflow-hidden login-split-card">
        <div class="row g-0">

            <!-- Brand panel -->
            <div class="col-md-5 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div class="inline-logo">
                        <?= Html::img(
                            Yii::getAlias('@web/images/lightbulb-logo.svg'),
                            ['alt' => 'sm-logo', 'height' => 64]
                        ) ?>
                        <?= Yii::$app->name ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            <?= Yii::t('app', 'Join Us<br>Today') ?>
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            <?= Yii::t('app', 'Create an account to get started.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form panel -->
            <div class="col-md-7">
                <div class="p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="d-md-none mb-3 inline-logo">
                            <?= Html::img(
                                Yii::getAlias('@web/images/lightbulb-logo.svg'),
                                ['alt' => Yii::$app->name, 'height' => 64]
                            ) ?>
                            <?= Yii::$app->name ?>
                        </div>
                        <h1 class="h3 fw-bold mb-1"><?= Html::encode($this->title) ?></h1>
                        <p class="text-body-secondary small">
                            <?= Yii::t('app', 'Fill in the details below to create your account.') ?>
                        </p>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                    <div class="mb-3">
                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-man"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 16v5" /><path d="M14 16v5" /><path d="M9 9h6l-1 7h-4l-1 -7" /><path d="M5 11c1.333 -1.333 2.667 -2 4 -2" /><path d="M19 11c-1.333 -1.333 -2.667 -2 -4 -2" /><path d="M10 4a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>'),
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => true],
                        ])->textInput()->label('Username', $labelOptions) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'email', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>'),
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'you@example.com'],
                        ])->textInput(['type' => 'email'])->label('Email', $labelOptions) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'password', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>'),
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password'],
                        ])->passwordInput()->label('Password', $labelOptions) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'password_confirm', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>'),
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Confirm password'],
                        ])->passwordInput()->label('Confirm Password', $labelOptions) ?>
                    </div>

                    <div class="d-grid mb-3">
                        <?= Html::submitButton('Create Account', [
                            'class' => 'btn login-btn btn-lg rounded-3 text-white',
                            'name' => 'signup-button',
                        ]) ?>
                    </div>

                    <p class="text-center text-body-secondary small mb-0">
                        Already have an account?
                        <?= Html::a('Log in', ['user/login']) ?>
                    </p>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>
    </div>
</div>