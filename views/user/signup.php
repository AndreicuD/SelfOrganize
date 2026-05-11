<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Create an account';
//$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Create an account.';
$this->params['meta_keywords'] = 'yii, yii2, signup, sign up, authentication';
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
                            [
                                'alt' => 'Yii Framework',
                                'height' => 64,
                            ],
                        ) ?>
                        <?= Yii::$app->name ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            <?= Yii::t('app', 'Welcome<br>Back') ?>
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            <?= Yii::t('app', 'Log in to access your data and manage your account.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form panel -->
            <div class="col-md-7">
                <div class="p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <!-- Mobile-only logo -->
                        <div class="d-md-none mb-3 inline-logo">
                            <?= Html::img(
                                Yii::getAlias('@web/images/lightbulb-logo.svg'),
                                [
                                    'alt' => 'Yii Framework',
                                    'height' => 64,
                                ],
                            ) ?>
                            <?= Yii::$app->name ?>
                        </div>
                        <h1 class="h3 fw-bold mb-1"><?= Html::encode($this->title) ?></h1>
                        <p class="text-body-secondary small"><?= Yii::t('app', 'Enter your credentials to continue</p>') ?>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <div class="mb-3">
                        <?= $form->field($model, 'username', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '&#128100;'),
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'username',
                                'autofocus' => true,
                            ],
                        ])->textInput()->label('Your Username', $labelOptions) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'password', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '&#128274;'),
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Password',
                            ],
                        ])->passwordInput()->label('Your Password', $labelOptions) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>

                    <div class="d-grid">
                        <?= Html::submitButton(
                            'Login',
                            [
                                'class' => 'btn login-btn btn-lg rounded-3 text-white',
                                'name' => 'login-button',
                            ],
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>
