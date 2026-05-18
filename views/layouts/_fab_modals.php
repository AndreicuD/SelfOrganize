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
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
                ])->dropDownList(
                    ArrayHelper::map($accounts, 'id', 'name'),
                    ['class' => 'form-select', 'prompt' => Yii::t('app', 'Select account')]
                ) ?>
            </div>

            <div class="mb-3">
                <?= $expenseForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💸</span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $expenseForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">📝</span>{input}{error}</div>',
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
                        'class' => 'btn btn-primary w-100 rounded-3 text-white',
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
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
                ])->dropDownList(
                    ArrayHelper::map($accounts, 'id', 'name'),
                    ['class' => 'form-select', 'prompt' => Yii::t('app', 'Select account')]
                ) ?>
            </div>

            <div class="mb-3">
                <?= $incomeForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💸</span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $incomeForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">📝</span>{input}{error}</div>',
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
                        'class' => 'btn btn-primary w-100 rounded-3 text-white',
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
                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
            ])->dropDownList(
                ArrayHelper::map($accounts, 'id', 'name'),
                ['class' => 'form-select', 'prompt' => Yii::t('app', 'From account')]
            ) ?>

            <?= $transferForm->field($transactionModel, 'to_account_id', [
                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">🏦</span>{input}{error}</div>',
            ])->dropDownList(
                ArrayHelper::map($accounts, 'id', 'name'),
                ['class' => 'form-select', 'prompt' => Yii::t('app', 'To account')]
            ) ?>

            <div class="mb-3">
                <?= $transferForm->field($transactionModel, 'amount', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">💸</span>{input}{error}</div>',
                ])->textInput([
                    'type'        => 'number',
                    'placeholder' => '0.00',
                    'step'        => '0.01',
                    'min'         => '0.01',
                    'class'       => 'form-control',
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $transferForm->field($transactionModel, 'note', [
                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">📝</span>{input}{error}</div>',
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
                        'class' => 'btn btn-primary w-100 rounded-3 text-white',
                    ]) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

      </div>
    </div>
  </div>
</div>
