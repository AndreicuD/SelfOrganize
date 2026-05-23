<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact us';
//$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'Get in touch with us. Send us a message using the contact form.';
$this->params['meta_keywords'] = 'yii, yii2, contact, support, feedback';
$htmlIcon = <<<HTML
{label}<div class="input-group"><span class="input-group-text" aria-hidden="true">%s</span>{input}</div>{error}{hint}
HTML;
$labelOptions = ['class' => 'form-label fw-semibold small'];
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>

<div class="site-contact-success d-flex align-items-center justify-content-center text-center">
    <div class="site-contact-success-content mx-auto">
        <h1 class="display-6 fw-semibold mb-3">Message sent</h1>

        <?php if (YII_DEBUG && Yii::$app->mailer->useFileTransport): ?>
            <p class="text-body-tertiary small mb-4">
                Development mode: email saved under
                <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>
            </p>
        <?php endif; ?>

        <?= Html::a(
            'Send another message',
            ['contact'],
            ['class' => 'btn btn-outline-primary btn-lg'],
        ) ?>
    </div>
</div>

<?php else: ?>

<div class="site-contact d-flex align-items-center justify-content-center py-5">
    <div class="card border-0 overflow-hidden login-split-card login-split-card-wide">
        <div class="row g-0">

            <!-- Brand panel -->
            <div class="col-md-4 d-none d-md-flex login-brand-panel text-white">
                <div class="d-flex flex-column justify-content-between p-4 p-lg-5 w-100">
                    <div class="inline-logo">
                        <?= Html::img(
                            Yii::getAlias('@web/images/lightbulb-logo.svg'),
                            [
                                'alt' => 'Self Organize',
                                'height' => 64,
                            ],
                        ) ?>
                        <?= Yii::$app->name ?>
                    </div>
                    <div>
                        <h2 class="fw-bold mb-3 login-brand-title">
                            <?= Yii::t('app', 'Get In') ?><br><?= Yii::t('app', 'Touch') ?>
                        </h2>
                        <p class="opacity-75 mb-0 login-brand-text">
                            <?= Yii::t('app', 'Have a question or business inquiry? We would love to hear from you.') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form panel -->
            <div class="col-md-8">
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
                        <p class="text-body-secondary small"><?= Yii::t('app', 'Fill out the form below and we will get back to you.') ?></p>
                    </div>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <?= $form->field($model, 'name', [
                                'options' => ['class' => 'mb-0'],
                                'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-man"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 16v5" /><path d="M14 16v5" /><path d="M9 9h6l-1 7h-4l-1 -7" /><path d="M5 11c1.333 -1.333 2.667 -2 4 -2" /><path d="M19 11c-1.333 -1.333 -2.667 -2 -4 -2" /><path d="M10 4a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /></svg>'),
                                'inputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'Name',
                                    'autofocus' => true,
                                ],
                            ])->label('Your Name', $labelOptions) ?>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <?= $form->field($model, 'email', [
                                'options' => ['class' => 'mb-0'],
                                'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" /><path d="M3 7l9 6l9 -6" /></svg>'),
                                'inputOptions' => [
                                    'class' => 'form-control',
                                    'placeholder' => 'email@example.com',
                                ],
                            ])->label('Your Email', $labelOptions) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'subject', [
                            'options' => ['class' => 'mb-0'],
                            'template' => sprintf($htmlIcon, '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-hipchat"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M17.802 17.292s.077 -.055 .2 -.149c1.843 -1.425 3 -3.49 3 -5.789c0 -4.286 -4.03 -7.764 -9 -7.764c-4.97 0 -9 3.478 -9 7.764c0 4.288 4.03 7.646 9 7.646c.424 0 1.12 -.028 2.088 -.084c1.262 .82 3.104 1.493 4.716 1.493c.499 0 .734 -.41 .414 -.828c-.486 -.596 -1.156 -1.551 -1.416 -2.29l-.002 .001" /><path d="M7.5 13.5c2.5 2.5 6.5 2.5 9 0" /></svg>'),
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Subject',
                            ],
                        ])->label('Subject', $labelOptions) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'body', [
                            'options' => ['class' => 'mb-0'],
                            'template' => '{label}{input}{error}{hint}',
                            'inputOptions' => [
                                'class' => 'form-control',
                                'placeholder' => 'Your message...',
                            ],
                        ])->textarea()->label('Message', $labelOptions) ?>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?= $form->field($model, 'verifyCode', [
                            'enableLabel' => false,
                            'options' => ['class' => ''],
                            'inputOptions' => ['aria-label' => 'Verification code'],
                        ])->widget(Captcha::class, [
                            'template' => '<div class="d-flex align-items-center gap-2">{image}{input}</div>',
                        ]) ?>

                        <?= Html::submitButton(
                            'Submit',
                            [
                                'class' => 'btn login-btn text-white px-4 ms-auto',
                                'name' => 'contact-button',
                            ],
                        ) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php endif; ?>
