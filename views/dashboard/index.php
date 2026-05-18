<?php

/** @var yii\web\View $this */

use yii\models\User;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$accountModel = new app\models\Account();
use app\models\Account;

$this->title = 'Dashboard';
//$this->params['breadcrumbs'][] = $this->title;
$this->params['meta_description'] = 'User Dashboard with Life Statistics.';
$this->params['meta_keywords'] = 'yii, yii2, dashboard, statistics, php, framework';
?>
<div class="user-dashboard">
    <div class="container">
        <div class="row row-cols-1 py-4 g-3">
    
            <div class="col-md-8">
                <div class="card col-card h-100">
                    <div class="card-body" style="position: relative; overflow: hidden;">
                        <h3 class="card-title"><?= Yii::t('app', 'Welcome back') ?>, <span class="accent-color"><?= $user->username ?></span>!</h3>
                        <p class="card-text"><?= Yii::t('app', 'Today you have to do') ?> <a class="accent-color" href="#">X <?= Yii::t('app', 'tasks') ?></a>.</p>
                        <br>
                        <canvas id="welcomeTrendChart" width="300" height="60" style="position: absolute; bottom: 0; right: 0; opacity: 0.6;"></canvas>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                <?= Yii::t('app', 'New Account') ?>
            </button>
        </div>

        <!-- Mobile grid -->
        <div class="accounts-grid-mobile row row-cols-1 g-4">
            <?php foreach ($accounts as $account): ?>
                <?= $this->render('_account_card', ['account' => $account]) ?>
            <?php endforeach; ?>
        </div>

        <!-- Desktop carousel -->
        <div class="accounts-carousel-wrapper">
            <?php if(!empty($accounts)): ?>
                <button class="accounts-nav-btn accounts-nav-prev" id="accounts-prev" aria-label="Previous">&#8592;</button>
            <?php endif; ?>
            <div class="accounts-carousel" id="accounts-carousel">
                <?php foreach ($accounts as $account): ?>
                    <?= $this->render('_account_card', ['account' => $account]) ?>
                <?php endforeach; ?>
            </div>
            <?php if(!empty($accounts)): ?>
                <button class="accounts-nav-btn accounts-nav-next" id="accounts-next" aria-label="Next">&#8594;</button>
            <?php endif; ?>
        </div>

        <?php if (empty($accounts)): ?>
            <div class="col-12">
                <p class="text-body-secondary small">
                    <?= Yii::t('app', 'No accounts yet. Create one to get started.') ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if(!empty($accounts)): ?>
            
            <div class="finance-tabs">
                <button class="finance-tab active" data-tab="transactions">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7l-4 4l4 4" /><path d="M5 11h11a4 4 0 0 1 0 8h-1" /></svg>
                    <?= Yii::t('app', 'Transactions') ?>
                </button>
                <button class="finance-tab" data-tab="income">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 9l-4 -4l-4 4" /></svg>
                    <?= Yii::t('app', 'Income') ?>
                </button>
                <button class="finance-tab" data-tab="expenses">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 15l-4 4l-4 -4" /></svg>
                    <?= Yii::t('app', 'Expenses') ?>
                </button>
                <button class="finance-tab" data-tab="transfers">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16l-4 -4l4 -4" /><path d="M3 12h18" /><path d="M17 8l4 4l-4 4" /></svg>
                    <?= Yii::t('app', 'Transfers') ?>
                </button>
            </div>

            <div class="finance-tab-content">

                <!-- TRANSACTIONS -->
                <div class="finance-panel active" id="tab-transactions">
                    <div class="row g-4 mt-0">
                        <div class="col-lg-6">
                            <div class="card col-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Recent Transactions') ?></h6>
                                        <a href="#" class="small accent-color"><?= Yii::t('app', 'View all') ?> →</a>
                                    </div>
                                    <?php if (empty($recentTransactions)): ?>
                                        <p class="text-body-secondary small"><?= Yii::t('app', 'No transactions yet.') ?></p>
                                    <?php else: ?>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-borderless align-middle mb-0 table-transactions">
                                                <thead>
                                                    <tr class="text-body-secondary small">
                                                        <th><?= Yii::t('app', 'Note') ?></th>
                                                        <th><?= Yii::t('app', 'Account') ?></th>
                                                        <th><?= Yii::t('app', 'Date') ?></th>
                                                        <th class="text-end"><?= Yii::t('app', 'Amount') ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recentTransactions as $t): ?>
                                                        <tr>
                                                            <td class="small"><?= Html::encode($t->note ?: '—') ?></td>
                                                            <td class="small text-body-secondary"><?= Html::encode($t->account->name) ?></td>
                                                            <td class="small text-body-secondary"><?= date('d M', strtotime($t->created_at)) ?></td>
                                                            <td class="text-end small fw-semibold <?= $t->isCredit() ? 'text-success' : 'text-danger' ?>">
                                                                <?= $t->isCredit() ? '+' : '-' ?><?= number_format($t->amount, 2) ?> <?= $t->currency ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card col-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Balance History') ?></h6>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm balance-range-btn active" data-days="7">7d</button>
                                            <button class="btn btn-sm balance-range-btn" data-days="30">30d</button>
                                        </div>
                                    </div>
                                    <canvas id="balanceHistoryChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INCOME -->
                <div class="finance-panel" id="tab-income">
                    <div class="card col-card mt-0">
                        <div class="card-body">
                            <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'No income recorded yet.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- EXPENSES -->
                <div class="finance-panel" id="tab-expenses">
                    <div class="card col-card mt-0">
                        <div class="card-body">
                            <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'No expenses recorded yet.') ?></p>
                        </div>
                    </div>
                </div>

                <!-- TRANSFERS -->
                <div class="finance-panel" id="tab-transfers">
                    <div class="card col-card mt-0">
                        <div class="card-body">
                            <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'No transfers recorded yet.') ?></p>
                        </div>
                    </div>
                </div>

            </div>
            
        <?php endif; ?>
        
        <br>
        <div class="row row-cols-1">
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card col-card">
                    <div class="card-body">
                        <p class="card-text">Ceva</p>
                    </div>
                </div>
            </div>
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