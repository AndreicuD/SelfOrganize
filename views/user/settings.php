<?php
/** @var yii\web\View $this */
/** @var app\models\User $userModel */
/** @var app\models\ChangePasswordForm $changePasswordModel */

use app\models\Account;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->params['pageJs']  = ['settings'];

$this->title = Yii::t('app', 'Settings');
?>

<div class="settings-page">

    <!-- Page title -->
    <div class="mb-4">
        <h2 class="fw-bold mb-1"><?= Yii::t('app', 'Settings') ?></h2>
        <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'Manage your account preferences') ?></p>
    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-6 d-flex flex-column gap-4">

            <!-- Account info -->
            <div class="card col-card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                        <?= Yii::t('app', 'Account Information') ?>
                    </h6>

                    <?php $form = ActiveForm::begin([
                        'id'     => 'form-change-info',
                        'action' => ['user/settings'],
                        'method' => 'post',
                    ]); ?>

                        <?= $form->errorSummary($userModel) ?>

                        <div class="mb-3">
                            <?= $form->field($userModel, 'username', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-man"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 16v5" /><path d="M14 16v5" /><path d="M9 9h6l-1 7h-4l-1 -7" /><path d="M5 11c1.333 -1.333 2.667 -2 4 -2" /><path d="M19 11c-1.333 -1.333 -2.667 -2 -4 -2" /><path d="M10 4a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>
                                </span>{input}{error}</div>',
                            ])->textInput([
                                'class'       => 'form-control',
                                'placeholder' => Yii::t('app', 'Your username'),
                            ]) ?>
                        </div>

                        <div class="mb-4">
                            <?= $form->field($userModel, 'email', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>
                                </span>{input}{error}</div>',
                            ])->textInput([
                                'class'       => 'form-control',
                                'placeholder' => Yii::t('app', 'Your email'),
                                'type'        => 'email',
                            ]) ?>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="reset" class="btn btn-outline-secondary w-100">
                                    <?= Yii::t('app', 'Reset') ?>
                                </button>
                            </div>
                            <div class="col">
                                <?= Html::submitButton(Yii::t('app', 'Save Changes'), [
                                    'class' => 'btn btn-accent w-100 rounded-3',
                                ]) ?>
                            </div>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <!-- Change password -->
            <div class="card col-card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                        <?= Yii::t('app', 'Change Password') ?>
                    </h6>

                    <?php $passwordForm = ActiveForm::begin([
                        'id'     => 'form-change-password',
                        'action' => ['user/change-password'],
                        'method' => 'post',
                    ]); ?>

                        <?= $passwordForm->errorSummary($changePasswordModel) ?>

                        <div class="mb-3">
                            <?= $passwordForm->field($changePasswordModel, 'current_password', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                </span>{input}{error}</div>',
                            ])->passwordInput([
                                'class'       => 'form-control',
                                'placeholder' => Yii::t('app', 'Current password'),
                            ])->label(Yii::t('app', 'Current Password')) ?>
                        </div>

                        <div class="mb-3">
                            <?= $passwordForm->field($changePasswordModel, 'new_password', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0" /><path d="M15 9h.01" /></svg>
                                </span>{input}{error}</div>',
                            ])->passwordInput([
                                'class'       => 'form-control',
                                'placeholder' => Yii::t('app', 'New password'),
                            ])->label(Yii::t('app', 'New Password')) ?>
                        </div>

                        <div class="mb-4">
                            <?= $passwordForm->field($changePasswordModel, 'confirm_password', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0" /><path d="M15 9h.01" /></svg>
                                </span>{input}{error}</div>',
                            ])->passwordInput([
                                'class'       => 'form-control',
                                'placeholder' => Yii::t('app', 'Confirm new password'),
                            ])->label(Yii::t('app', 'Confirm Password')) ?>
                        </div>

                        <p class="text-body-secondary small mb-3">
                            <?= Yii::t('app', 'Forgot your current password?') ?>
                            <?= Html::a(Yii::t('app', 'Reset it here'), ['user/request-password-reset']) ?>
                        </p>

                        <?= Html::submitButton(Yii::t('app', 'Change Password'), [
                            'class' => 'btn btn-accent w-100',
                        ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-6 d-flex flex-column gap-4">

            <!-- Accent color -->
            <div class="card col-card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 0 1 0 -18c4.97 0 9 3.582 9 8c0 1.06 -.474 2.078 -1.318 2.828c-.844 .75 -1.989 1.172 -3.182 1.172h-2.5a2 2 0 0 0 -1 3.75a1.3 1.3 0 0 1 -1 2.25" /><path d="M8.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M16.5 10.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                        <?= Yii::t('app', 'Accent Color') ?>
                    </h6>
                    <p class="text-body-secondary small mb-4"><?= Yii::t('app', 'Choose a color that makes the app feel like yours.') ?></p>

                    <?php $accentForm = ActiveForm::begin([
                        'id'     => 'form-accent',
                        'action' => ['user/save-accent'],
                        'method' => 'post',
                    ]); ?>

                        <?= Html::hiddenInput('accent', $userModel->preferred_accent ?? '#2596be', ['id' => 'accent-input']) ?>

                        <div class="accent-presets mb-3">
                            <?php
                            $presets = [
                                'default' => '#e91e63',
                                'ocean'   => '#2596be',
                                'slate'   => '#4f6bed',
                                'emerald' => '#10b981',
                                'teal'    => '#0d9488',
                                'violet'  => '#7c3aed',
                                'indigo'  => '#4338ca',
                                'amber'   => '#d97706',
                                'rose'    => '#e11d48',
                                'sage'    => '#16a34a',
                                'crimson' => '#dc2626',
                            ];
                            foreach ($presets as $name => $hex): ?>
                                <button type="button"
                                    class="accent-preset-btn <?= ($userModel->preferred_accent === $hex) ? 'active' : '' ?>"
                                    data-hex="<?= $hex ?>"
                                    title="<?= ucfirst($name) ?>"
                                    style="background-color: <?= $hex ?>;">
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <?= Html::submitButton(Yii::t('app', 'Save Color'), [
                            'class' => 'btn btn-accent w-100',
                        ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <!-- Preferred currency -->
            <div class="card col-card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 6v2m0 8v2" /></svg>
                        <?= Yii::t('app', 'Preferred Currency') ?>
                    </h6>
                    <p class="text-body-secondary small mb-4"><?= Yii::t('app', 'All balances will be converted and shown in this currency.') ?></p>

                    <?php $currencyForm = ActiveForm::begin([
                        'id'     => 'form-currency',
                        'action' => ['user/save-currency'],
                        'method' => 'post',
                    ]); ?>

                        <div class="mb-4">
                            <?= $currencyForm->field($userModel, 'preferred_currency', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg width="20px" height="20px" viewBox="0 0 128 128" fill="var(--accent)" stroke="var(--accent)" stroke-width="2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="var(--accent)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M89 105.16s-.01 3.76-.01 4.22s2.05 1.44 5.76 1.48s5.84-.9 5.84-1.23s-.03-4.41-.03-4.41s-2.69-2.61-5.12-2.67s-6.44 2.61-6.44 2.61z" fill="var(--accent)"></path><path d="M25.87 3.13c-1.04.01-1.57.11-1.57 2.47s.22 74.85.22 75.64c0 .79.79 1.12 2.14 1.12h5.51c.9 0 1.24-.56 1.12-2.02s-.13-74.62-.13-75.52s-.41-1.6-1.84-1.65c-1.17-.04-4.22-.05-5.45-.04z" fill="var(--accent)"></path><path d="M16.41 29.6s-.16-4.12 2.74-6.78c2.68-2.45 5.17-2.27 5.17-2.27l.02 4.08s1.52-.53 4.1-.42s4.7 1 4.7 1v-4.28s1.43-.06 3.58 2.47c1.08 1.27 1.97 3.91 2.26 5.29c.38 1.77 1.03 2.6 2.74 2.72c1.71.12 3.02.11 4.07.07c1.51-.05-3.21-8.25-3.21-8.25s-5.27-7.96-6.99-8.01c-1.72-.05-12.37.22-13.39.75c-1.02.54-7.69 5.22-7.69 5.22l-.91 7.26s2.53 2.96 2.53 2.74c.02-.19.28-1.59.28-1.59z" fill="var(--accent)"></path><path d="M11.3 29.6l-5.02-3.95s-1.07 8.14 2.99 13.04c2.97 3.59 6.45 5.06 9.52 6.4c2.86 1.26 5.63 2.12 5.63 2.12l.01 4.81l8.78 4.67l-.01-6.31s3.33 1.81 5 3.59c1.67 1.77 1.83 3.98 1.88 5.38c.05 1.4-.65 3.6-.65 3.6l-.97 4.3l11.19-11.29l-26.4-17.53L11.3 29.6z" fill="var(--accent)"></path><path d="M6.88 54.85S5.54 56 5.93 59.12c.36 2.9 1.99 7.42 6.88 11.4s11.7 4.74 11.7 4.74v3.32l8.74-.02l-.01-3.3s5.22-.22 9.63-3.02c4.61-2.93 7.99-8.9 7.79-14.5c-.07-1.97-1.32-1.66-1.32-1.66S33.3 69.99 32.23 70.1c-1.08.11-11.51-1.72-11.51-1.72l-9.73-10.59l-4.11-2.94z" fill="var(--accent)"></path><path d="M10.98 53.69c-3.27.32-4.41.97-4.46 1.94c-.05.97 2.8 17.87 22.69 17.59c19.09-.27 21.35-11.88 21.51-16.4c.19-5.43-3.01-9.95-10.22-14.2c-5.37-3.16-18.34-7.91-20.49-9.25c-1.98-1.24-4.73-3.98-4.36-8.07c.38-4.09 4.84-8.12 13.07-8.07c8.23.05 11.47 5.78 12.1 7.48c1.01 2.73.82 6.28 2.31 6.75c.7.22 2.74.13 3.92-.03c1.18-.16 2.86-1.07 2.96-3.44c.11-2.74-2.74-18.07-21.78-17.91c-18.18.15-22.65 11.3-21.95 17.7c.66 6.07 5.6 11.77 13.56 15s22.05 7.15 21.89 14.41c-.14 6.51-7.7 8.82-13.93 8.5c-6.29-.32-9.73-3.98-11.02-8.28c-1.23-4.13-3.59-3.93-5.8-3.72z" fill="var(--accent)"></path><path d="M14 55.75c-.67-1.25-5.15-1.06-5.73 1.06s1.47 5.41 2.85 5.12c1.88-.39.29-2.66 1.02-3.52c.74-.87 2.69-1.11 1.86-2.66z" fill="var(--accent)"></path><path d="M28.4 4.25c-1.31-.03-2.78-.05-2.85 1.72c-.07 1.7.04 3.01.71 3.08c.75.08 1.81-1.54 2.27-2.24c.57-.89 1.28-2.52-.13-2.56z" fill="var(--accent)"></path><path d="M18.35 14.62c-.5-.73-3.31-1.31-7.19 3.48s-2.45 7.33-1.56 7.44c1.21.15 1.88-.84 2.62-2.47c1.06-2.32 2.32-3.73 4.29-5.22c1.68-1.27 2.7-1.97 1.84-3.23z" fill="var(--accent)"></path><path d="M74.01 84.47v1.79c0 .6.51 1.09 1.73 1.14c1.22.05 38.59.1 38.81.08c.38-.04.39-.49.39-.77c.03-1.1.02-2.23.02-2.23L79.9 82.64l-5.89 1.83z" fill="var(--accent)"></path><path d="M74.02 94.71v2.86c.01.53.42.63 1.17.64h38.36c.54 0 .97-.31.99-.91c.03-.82.01-2.59.01-2.59l-20.21-2.13l-20.32 2.13z" fill="var(--accent)"></path><path fill="var(--accent)" d="M74 79.85h40.96v4.66H74z"></path><path fill="var(--accent)" d="M74.01 90.39h40.55v4.35H74.01z"></path><path d="M89 105.16l.52-25.33S66.29 45.01 66.55 44.48c.27-.53 13.7-.28 14.37.12c.67.4 13.91 21.31 14.49 21.3c.6-.01 13.22-20.56 13.75-20.96c.53-.4 14.29-.52 14.29.02s-22.98 34.93-22.98 34.93l.09 25.41s-3.52.23-5.78.23s-5.78-.37-5.78-.37z" fill="var(--accent)"></path><path d="M79.13 46.83c.03.71-4.02 4.62-4.82 4.62c-.8 0-2.83-2.73-3.27-4.32c-.3-1.08 3.16-1.27 4.48-1.27c1.33.01 3.57.05 3.61.97z" fill="var(--accent)"></path><path d="M110.55 47.08c-.43.26-4.17 4.49-2.52 5.81c1.17.94 3.52-1.35 5.32-2.15c1.8-.8 4.77-1.46 4.74-2.94c-.04-1.82-5.97-1.68-7.54-.72z" fill="var(--accent)"></path><path d="M54.67 16.64c1.03 1.41 5.05-.66 8.44-1.16c3.39-.5 8.94-1.41 17.13 2.48s12.99 9.52 12.91 9.93c-.08.41-7.61 2.37-9.76 3.45c-1.8.9-2.55 2.16-2.24 3.67c.29 1.43 1.42 2.2 3.07 2.61c2.88.72 22.73 2.65 25.71-.17c3.74-3.53 2.79-22.18 2.56-24.38c-.34-3.37-1.28-4.51-2.98-4.79c-1.49-.25-2.98.41-3.89 2.67c-1.03 2.54-2.8 8.99-3.3 8.99s-5.86-8.1-15.38-11.41s-17.95-1.82-23 .08c-5.4 2.04-10.59 6.21-9.27 8.03z" fill="var(--accent)"></path><path d="M42.34 103.09c-.33.44 4.19 8.2 14.03 11.11s21.33-2.27 22.59.18c1.64 3.19-12.35 13.85-29.6 8.11c-14.48-4.82-16.85-14.12-17.3-14.03s-3.98 4.67-4.92 5.74c-2.2 2.5-7.38 1-6.01-3.73c1.85-6.42 6.75-20.99 9.38-21.95c3.52-1.29 20.95 7.37 22.22 8.11c2.37 1.37 2.91 5.65-1.37 5.92c-2.64.16-8.74.18-9.02.54z" fill="var(--accent)"></path></g></svg>
                                </span>{input}{error}</div>',
                            ])->dropDownList(
                                Account::currencyList(),
                                ['class' => 'form-select']
                            ) ?>
                        </div>

                        <?= Html::submitButton(Yii::t('app', 'Save Currency'), [
                            'class' => 'btn btn-accent w-100',
                        ]) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <!-- Dashboard order — placeholder for future -->
            <div class="card col-card">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 6l16 0" /><path d="M4 12l16 0" /><path d="M4 18l16 0" /></svg>
                        <?= Yii::t('app', 'Dashboard Layout') ?>
                    </h6>
                    <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'Choose what appears first on your dashboard. Coming soon.') ?></p>
                    <div class="mt-3">
                        <span class="badge bg-secondary"><?= Yii::t('app', 'Coming soon') ?></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>