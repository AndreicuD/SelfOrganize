<?php

/** @var yii\web\View $this */

use yii\models\User;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$accountModel = new app\models\Account();
use app\models\Account;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'User Dashboard with Life Statistics.';
$this->params['meta_keywords'] = 'yii, yii2, dashboard, statistics, php, framework';
?>
<div class="user-dashboard">
    <div class="container">
        <div class="row row-cols-1 py-4 g-3">
    
            <div class="col-md-8">
                <div class="card col-card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><?= Yii::t('app', 'Welcome back') ?>, <span class="accent-color"><?= $user->username ?></span>!</h3>
                        <p class="card-text"><?= Yii::t('app', 'Today you have to do') ?> <a class="accent-color" href="#">X <?= Yii::t('app', 'tasks') ?></a>.</p>
                    </div>
                </div>
            </div>
    
    
            <div class="col-sm-4">
                <div class="card col-card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><?= Yii::t('app', 'Balance') ?>: <span class="accent-color"><?= number_format($totalBalance,2) ?><?= Html::encode($user->preferred_currency ?? '') ?></span></h3>
                        <p class="card-text"><?= Yii::t('app', 'Total balance converted into prefered currency.') ?></p>
                    </div>
                </div>
            </div>
    
        </div>

        <div class="dashboard-inline-title">
            <h3>Finance:</h3>
            <hr class="inline-hr">
            <button class="btn btn-accent inline-button" data-bs-toggle="modal" data-bs-target="#newAccountModal">
                + <?= Yii::t('app', 'New Account') ?>
            </button>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="accounts-grid">
            <?php foreach ($accounts as $account): ?>
                <div class="col">
                    <div class="card col-card card-account card-account-<?=$account->type?> h-100">
                        <div class="card-body">
                            <p class="card-title">
                                <b><?= Html::encode($account->name) ?>:</b>
                                <span class="accent-color">
                                    <?= number_format($account->balance, 2) ?> <?= Html::encode($account->currency) ?>
                                </span>
                            </p>
                            <p class="card-subtitle account-type">
                                <?= Html::encode(Account::currencyName($account->currency)) ?> - <?= Html::encode(Account::typeList()[$account->type]) ?>
                            </p>
                            <div class="mt-2 d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary edit-account-btn"
                                    data-id="<?= $account->id ?>"
                                    data-name="<?= Html::encode($account->name) ?>"
                                    data-currency="<?= Html::encode($account->currency) ?>"
                                    data-type="<?= Html::encode($account->type) ?>"
                                    data-balance="<?= $account->balance ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAccountModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" /><path d="M16 5l3 3" /></svg>
                                    <?= Yii::t('app', 'Edit') ?>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-account-btn"
                                    data-id="<?= $account->id ?>"
                                    data-name="<?= Html::encode($account->name) ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteAccountModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                    <?= Yii::t('app', 'Delete') ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (empty($accounts)): ?>
                <div class="col-12">
                    <p class="text-body-secondary small">
                        <?= Yii::t('app', 'No accounts yet. Create one to get started.') ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        
    </div>  
</div>

<!--<div class="row">
    <div class="col">
        <div class="card col-card card-account h-100" >
            <div class="card-body">
                <p class="card-title"><b>[CARD NAME]:</b> <span class="accent-color">[AMOUNT][CURRENCY]</span></p>
                <p class="card-subtitle account-type">[CARD TYPE]</p>
            </div>
        </div>
    </div>
</div>-->

<!-- New Account Modal -->
<div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 p-lg-5">

        <div class="text-center mb-4">
          <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'New Account') ?></h1>
          <p class="text-body-secondary small"><?= Yii::t('app', 'Add a new account to track your finances') ?></p>
        </div>

        <?php $form = ActiveForm::begin([
          'id'     => 'form-new-account',
          'action' => ['finance/create-account'],
          'options' => ['data-account-form' => true],
        ]); ?>

            <?= $form->errorSummary($accountModel) ?>

            <div class="mb-3">
            <?= $form->field($accountModel, 'name', [
                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
            ])->textInput([
                'placeholder' => 'e.g. Revolut EUR',
                'class'       => 'form-control',
            ]) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($accountModel, 'currency', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💱</span>{input}{error}</div>',
                ])->dropDownList(
                    Account::currencyList(),
                    ['class' => 'form-select']
                ) ?>
            </div>

            <div class="mb-3">
                <?= $form->field($accountModel, 'type', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">📂</span>{input}{error}</div>',
                ])->dropDownList(
                    Account::typeList(),
                    ['class' => 'form-select']
                ) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($accountModel, 'balance', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💰</span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0',
                    'class'       => 'form-control',
                    'value'       => '0.00',
                ]) ?>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                    <?= Yii::t('app', 'Cancel') ?>
                    </button>
                </div>
                <div class="col">
                    <?= Html::submitButton(Yii::t('app', 'Create Account'), [
                    'class' => 'btn btn-primary w-100 rounded-3 text-white',
                    ]) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>

<?php if (Yii::$app->session->getFlash('openAccountModal')): ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('newAccountModal')).show();
  });
</script>
<?php endif; ?>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4 p-lg-5">

                <div class="text-center mb-4">
                    <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Edit Account') ?></h1>
                    <p class="text-body-secondary small"><?= Yii::t('app', 'Update your account details') ?></p>
                </div>

                <?php $editForm = ActiveForm::begin([
                'id'     => 'form-edit-account',
                'action' => ['finance/update-account'],
                ]); ?>

                <?= $editForm->errorSummary($editAccountModel) ?>

                <?= Html::hiddenInput('id', '', ['id' => 'edit-account-id']) ?>

                <div class="mb-3">
                    <?= $editForm->field($editAccountModel, 'name', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
                    ])->textInput([
                    'class' => 'form-control',
                    'id'    => 'edit-account-name',
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $editForm->field($editAccountModel, 'currency', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💱</span>{input}{error}</div>',
                    ])->dropDownList(
                    Account::currencyList(),
                    ['class' => 'form-select', 'id' => 'edit-account-currency']
                    ) ?>
                </div>

                <div class="mb-3">
                    <?= $editForm->field($editAccountModel, 'type', [
                        'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">📂</span>{input}{error}</div>',
                    ])->dropDownList(
                        Account::typeList(),
                        ['class' => 'form-select', 'id' => 'edit-account-type']
                    ) ?>
                </div>

                <div class="mb-4">
                    <?= $editForm->field($editAccountModel, 'balance', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💰</span>{input}{error}</div>',
                    ])->textInput([
                    'type'  => 'number',
                    'step'  => '0.01',
                    'min'   => '0',
                    'class' => 'form-control',
                    'id'    => 'edit-account-balance',
                    ]) ?>
                </div>

                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                            <?= Yii::t('app', 'Cancel') ?>
                        </button>
                    </div>
                    <div class="col">
                        <?= Html::submitButton(Yii::t('app', 'Save Changes'), [
                            'class' => 'btn btn-primary w-100 rounded-3 text-white',
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4 p-lg-5 text-center">

                <p class="fs-1 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 7l16 0" />
                        <path d="M10 11l0 6" />
                        <path d="M14 11l0 6" />
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                    </svg>
                </p>
                <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Delete Account') ?></h1>
                <p class="text-body-secondary small mb-4">
                <?= Yii::t('app', 'Are you sure you want to delete') ?>
                <b id="delete-account-name"></b>?
                <br>
                <?= Yii::t('app', 'This action cannot be undone.') ?>
                </p>

                <?php $deleteForm = ActiveForm::begin([
                'id'     => 'form-delete-account',
                'action' => ['finance/delete-account'],
                ]); ?>

                <?= Html::hiddenInput('id', '', ['id' => 'delete-account-id']) ?>

                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
                            <?= Yii::t('app', 'Cancel') ?>
                        </button>
                    </div>
                    <div class="col">
                        <?= Html::submitButton(Yii::t('app', 'Delete'), [
                            'class' => 'btn btn-danger w-100',
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>