<?php
/** @var app\models\Transaction $transactionModel */
/** @var app\models\Account[] $accounts */

use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 p-lg-5">

        <div class="text-center mb-4">
          <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Add Expense') ?></h1>
          <p class="text-body-secondary small"><?= Yii::t('app', 'Record a new expense.') ?></p>
        </div>

        <?php $expenseForm = ActiveForm::begin([
            'id'     => 'form-add-expense',
            'action' => ['transaction/add'],
        ]); ?>

            <?= $expenseForm->errorSummary($transactionModel) ?>
            <?= Html::hiddenInput('Transaction[type]', 'expense') ?>

            <div class="mb-3">
                <?= $expenseForm->field($transactionModel, 'account_id', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                    </span>{input}{error}</div>',
                ])->dropDownList(
                    ArrayHelper::map($accounts, 'id', 'name'),
                    ['class' => 'form-select', 'prompt' => Yii::t('app', 'Select account')]
                ) ?>
            </div>

            <div class="mb-3">
                <?= $expenseForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-3">
                <?= $expenseForm->field($transactionModel, 'transaction_date', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                        <path d="M16 3v4"/>
                        <path d="M8 3v4"/>
                        <path d="M4 11h16"/>
                    </svg>
                    </span>{input}{error}</div>',
                ])->input('date', [
                    'class' => 'form-control',
                    'value' => $transactionModel->transaction_date
                        ? date('Y-m-d', strtotime($transactionModel->transaction_date))
                        : date('Y-m-d'),
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $expenseForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-note"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'placeholder' => Yii::t('app', 'e.g. Groceries (optional)'),
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                        <?= Yii::t('app', 'Cancel') ?>
                    </button>
                </div>
                <div class="col">
                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-accent w-100 rounded-3 text-white',
                    ]) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 p-lg-5">

        <div class="text-center mb-4">
          <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Add Income') ?></h1>
          <p class="text-body-secondary small"><?= Yii::t('app', 'Record new income.') ?></p>
        </div>

        <?php $incomeForm = ActiveForm::begin([
            'id'     => 'form-add-income',
            'action' => ['transaction/add'],
        ]); ?>

            <?= $incomeForm->errorSummary($transactionModel) ?>
            <?= Html::hiddenInput('Transaction[type]', 'income') ?>

            <div class="mb-3">
                <?= $incomeForm->field($transactionModel, 'account_id', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                    </span>{input}{error}</div>',
                ])->dropDownList(
                    ArrayHelper::map($accounts, 'id', 'name'),
                    ['class' => 'form-select', 'prompt' => Yii::t('app', 'Select account')]
                ) ?>
            </div>

            <div class="mb-3">
                <?= $incomeForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-3">
                <?= $incomeForm->field($transactionModel, 'transaction_date', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                        <path d="M16 3v4"/>
                        <path d="M8 3v4"/>
                        <path d="M4 11h16"/>
                    </svg>
                    </span>{input}{error}</div>',
                ])->input('date', [
                    'class' => 'form-control',
                    'value' => $transactionModel->transaction_date
                        ? date('Y-m-d', strtotime($transactionModel->transaction_date))
                        : date('Y-m-d'),
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $incomeForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-note"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'placeholder' => Yii::t('app', 'e.g. Groceries (optional)'),
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                        <?= Yii::t('app', 'Cancel') ?>
                    </button>
                </div>
                <div class="col">
                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-accent w-100 rounded-3 text-white',
                    ]) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addTransferModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-4 p-lg-5">

        <div class="text-center mb-4">
          <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Add Transfer') ?></h1>
          <p class="text-body-secondary small"><?= Yii::t('app', 'Record a new transfer.') ?></p>
        </div>

        <?php $transferForm = ActiveForm::begin([
            'id'     => 'form-add-transfer',
            'action' => ['transaction/add'],
        ]); ?>

            <?= $transferForm->errorSummary($transactionModel) ?>
            <?= Html::hiddenInput('Transaction[type]', 'transfer_out') ?>

            <?= $transferForm->field($transactionModel, 'account_id', [
                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cash-banknote-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M12 18h-7a2 2 0 0 1 -2 -2v-8a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7" /><path d="M18 12h.01" /><path d="M6 12h.01" /><path d="M16 19h6" /></svg>
                </span>{input}{error}</div>',
            ])->dropDownList(
                ArrayHelper::map($accounts, 'id', 'name'),
                ['class' => 'form-select', 'prompt' => Yii::t('app', 'From account')]
            ) ?>

            <?= $transferForm->field($transactionModel, 'to_account_id', [
                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cash-banknote-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M12.25 18h-7.25a2 2 0 0 1 -2 -2v-8a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v4.5" /><path d="M18 12h.01" /><path d="M6 12h.01" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                </span>{input}{error}</div>',
            ])->dropDownList(
                ArrayHelper::map($accounts, 'id', 'name'),
                ['class' => 'form-select', 'prompt' => Yii::t('app', 'To account')]
            ) ?>

            <div class="mb-3">
                <?= $transferForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-3">
                <?= $transferForm->field($transactionModel, 'transaction_date', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/>
                        <path d="M16 3v4"/>
                        <path d="M8 3v4"/>
                        <path d="M4 11h16"/>
                    </svg>
                    </span>{input}{error}</div>',
                ])->input('date', [
                    'class' => 'form-control',
                    'value' => $transactionModel->transaction_date
                        ? date('Y-m-d', strtotime($transactionModel->transaction_date))
                        : date('Y-m-d'),
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $transferForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-note"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M13 20l7 -7" /><path d="M13 20v-6a1 1 0 0 1 1 -1h6v-7a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7" /></svg>
                    </span>{input}{error}</div>',
                ])->textInput([
                    'placeholder' => Yii::t('app', 'e.g. Groceries (optional)'),
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                        <?= Yii::t('app', 'Cancel') ?>
                    </button>
                </div>
                <div class="col">
                    <?= Html::submitButton(Yii::t('app', 'Save'), [
                        'class' => 'btn btn-accent w-100 rounded-3 text-white',
                    ]) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>
