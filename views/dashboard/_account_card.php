<?php
/** @var app\models\Account $account */
use yii\helpers\Html;
use app\models\Account;
?>
<div class="account-slide col">
    <div class="card col-card card-account card-account-<?= $account->type ?> h-100">
        <div class="card-body">
            <p class="card-title">
                <b><?= Html::encode($account->name) ?>:</b>
                <span class="accent-color">
                    <?= number_format($account->balance, 2) ?> <?= Html::encode($account->currency) ?>
                </span>
            </p>
            <p class="card-subtitle account-type">
                <?= Html::encode(Account::currencyName($account->currency)) ?> — <?= Html::encode(Account::typeList()[$account->type]) ?>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    <?= Yii::t('app', 'Delete') ?>
                </button>
            </div>
        </div>
    </div>
</div>