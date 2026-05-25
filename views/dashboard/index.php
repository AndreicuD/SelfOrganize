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

$this->params['showFab'] = true;
$this->params['pageJs']  = ['chart', 'finance', 'dashboard'];
$this->params['layout'] = 'dashboard';

?>
<div class="user-dashboard">
    <div class="container">
        <div class="row row-cols-1 py-2 g-4 mb-2">
    
            <div class="col-md-8">
                <div class="card col-card h-100">
                    <div class="card-body" style="position: relative; overflow: hidden;">
                        <h3 class="card-title"><?= Yii::t('app', 'Welcome back') ?>, <span class="accent-color"><?= $user->username ?></span>!</h3>
                        <p class="card-text text-body-secondary"><?= Yii::t('app', 'Hope you feel well!') ?></p>
                        <br>
                        <canvas id="welcomeTrendChart" width="300" height="60" style="position: absolute; bottom: 0; right: 0; opacity: 0.3;"></canvas>
                    </div>
                </div>
            </div>
    
    
            <div class="col-sm-4">
                <div class="card col-card h-100">
                    <div class="card-body">
                        <h3 class="card-title"><?= Yii::t('app', 'Balance') ?>: 
                        <br>
                        <span class="accent-color"><?= number_format($totalBalance,2) ?><?= Html::encode($user->preferred_currency ?? '') ?></span></h3>
                        <p class="card-text"><?= Yii::t('app', 'Total balance converted into prefered currency.') ?></p>
                    </div>
                </div>
            </div>
    
        </div>

        <hr>

        <!-- Second row — Notifications + Tasks + Calendar -->
        <div class="row row-cols-1 row-cols-md-3 py-2 g-3 mb-2">

            <!-- Notifications -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon position-relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bell accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                            <?php if ($unreadNotifications > 0): ?>
                                <span class="notification-dot"></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Notifications') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?php if ($unreadNotifications > 0): ?>
                                    <?= $unreadNotifications ?> <?= Yii::t('app', 'Unread') ?>
                                <?php else: ?>
                                    <?= Yii::t('app', "You're all caught up!") ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Notes -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="accent-color icon icon-tabler icons-tabler-outline icon-tabler-notebook"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" /><path d="M13 8l2 0" /><path d="M13 12l2 0" /></svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Notes') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?= Yii::t('app', 'Journal your way through life!') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Calendar -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="accent-color icon icon-tabler icons-tabler-outline icon-tabler-calendar-event"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2l0 -12" /><path d="M16 3l0 4" /><path d="M8 3l0 4" /><path d="M4 11l16 0" /><path d="M8 15h2v2h-2l0 -2" /></svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Calendar') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?= Yii::t('app', 'View upcoming events') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- Third row — Tasks + Goals + Projects -->
        <div class="row row-cols-1 row-cols-md-3 g-3 mb-2">

            <!-- Tasks -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="accent-color icon icon-tabler icons-tabler-outline icon-tabler-list-check"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3.5 5.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 11.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 17.5l1.5 1.5l2.5 -2.5" /><path d="M11 6l9 0" /><path d="M11 12l9 0" /><path d="M11 18l9 0" /></svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Tasks') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?= ($remainingTasks > 0) ? $remainingTasks : Yii::t('app', 'None') ?> <?= Yii::t('app', 'due today') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Goals -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Goals') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?= Yii::t('app', 'Keep track!') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Projects -->
            <div class="col">
                <a href="#" class="card col-card h-100 dashboard-shortcut-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="dashboard-shortcut-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="accent-color icon icon-tabler icons-tabler-outline icon-tabler-device-desktop-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 16h-8a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v7" /><path d="M7 20h5" /><path d="M9 16v4" /><path d="M17.001 19a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0 fw-semibold"><?= Yii::t('app', 'Projects') ?></h5>
                            <p class="text-body-secondary small mb-0">
                                <?= Yii::t('app', 'Keep track!') ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <!-- ---------------------------- -->

        <div id='finance-section'>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 15l-4 4l-4 -4" /></svg>
                        <?= Yii::t('app', 'Income') ?>
                    </button>
                    <button class="finance-tab" data-tab="expenses">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 9l-4 -4l-4 4" /></svg>
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
                            <script id="balanceHistoryWeek" type="application/json">
                                <?= json_encode($balanceHistory7) ?>
                            </script>
                            <script id="balanceHistoryMonth" type="application/json">
                                <?= json_encode($balanceHistory30) ?>
                            </script>
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Balance History') ?></h6>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm balance-range-btn chart-range-btn active" data-days="7">7d</button>
                                                <button class="btn btn-sm balance-range-btn chart-range-btn" data-days="30">30d</button>
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
                        <div class="row g-4 mt-0">
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Income') ?></h6>
                                            <a href="#" class="small accent-color"><?= Yii::t('app', 'View all') ?> →</a>
                                        </div>
                                        <?php
                                        $incomeTransactions = array_filter($recentTransactions, fn($t) => $t->type === 'income');
                                        ?>
                                        <?php if (empty($incomeTransactions)): ?>
                                            <p class="text-body-secondary small"><?= Yii::t('app', 'No income recorded yet.') ?></p>
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
                                                        <?php foreach ($incomeTransactions as $t): ?>
                                                            <tr>
                                                                <td class="small"><?= Html::encode($t->note ?: '—') ?></td>
                                                                <td class="small text-body-secondary"><?= Html::encode($t->account->name) ?></td>
                                                                <td class="small text-body-secondary"><?= date('d M', strtotime($t->created_at)) ?></td>
                                                                <td class="text-end small fw-semibold text-success">
                                                                    +<?= number_format($t->amount, 2) ?> <?= $t->currency ?>
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
                            <script id="incomeHistoryWeek" type="application/json">
                                <?= json_encode($incomeHistory7) ?>
                            </script>
                            <script id="incomeHistoryMonth" type="application/json">
                                <?= json_encode($incomeHistory30) ?>
                            </script>
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Income Summary') ?></h6>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm income-range-btn chart-range-btn active" data-days="7">7d</button>
                                                <button class="btn btn-sm income-range-btn chart-range-btn" data-days="30">30d</button>
                                            </div>
                                        </div>
                                        <canvas id="incomeChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EXPENSES -->
                    <div class="finance-panel" id="tab-expenses">
                        <div class="row g-4 mt-0">
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Expenses') ?></h6>
                                            <a href="#" class="small accent-color"><?= Yii::t('app', 'View all') ?> →</a>
                                        </div>
                                        <?php
                                        $expenseTransactions = array_filter($recentTransactions, fn($t) => $t->type === 'expense');
                                        ?>
                                        <?php if (empty($expenseTransactions)): ?>
                                            <p class="text-body-secondary small"><?= Yii::t('app', 'No expenses recorded yet.') ?></p>
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
                                                        <?php foreach ($expenseTransactions as $t): ?>
                                                            <tr>
                                                                <td class="small"><?= Html::encode($t->note ?: '—') ?></td>
                                                                <td class="small text-body-secondary"><?= Html::encode($t->account->name) ?></td>
                                                                <td class="small text-body-secondary"><?= date('d M', strtotime($t->created_at)) ?></td>
                                                                <td class="text-end small fw-semibold text-danger">
                                                                    -<?= number_format($t->amount, 2) ?> <?= $t->currency ?>
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
                            <script id="expenseHistoryWeek" type="application/json">
                                <?= json_encode($expenseHistory7) ?>
                            </script>
                            <script id="expenseHistoryMonth" type="application/json">
                                <?= json_encode($expenseHistory30) ?>
                            </script>
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Expenses Summary') ?></h6>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm expense-range-btn chart-range-btn active" data-days="7">7d</button>
                                                <button class="btn btn-sm expense-range-btn chart-range-btn" data-days="30">30d</button>
                                            </div>
                                        </div>
                                        <canvas id="expenseChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TRANSFERS -->
                    <div class="finance-panel" id="tab-transfers">
                        <div class="row g-4 mt-0">
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Transfers') ?></h6>
                                            <a href="#" class="small accent-color"><?= Yii::t('app', 'View all') ?> →</a>
                                        </div>
                                        <?php
                                        $transferTransactions = array_filter($recentTransactions, fn($t) => $t->type === 'transfer_out');
                                        ?>
                                        <?php if (empty($transferTransactions)): ?>
                                            <p class="text-body-secondary small"><?= Yii::t('app', 'No transfers recorded yet.') ?></p>
                                        <?php else: ?>
                                            <div class="table-responsive">
                                                <table class="table table-sm table-borderless align-middle mb-0 table-transactions">
                                                    <thead>
                                                        <tr class="text-body-secondary small">
                                                            <th><?= Yii::t('app', 'Note') ?></th>
                                                            <th><?= Yii::t('app', 'From') ?></th>
                                                            <th><?= Yii::t('app', 'To') ?></th>
                                                            <th><?= Yii::t('app', 'Date') ?></th>
                                                            <th class="text-end"><?= Yii::t('app', 'Amount') ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($transferTransactions as $t): ?>
                                                            <tr>
                                                                <td class="small"><?= Html::encode($t->note ?: '—') ?></td>
                                                                <td class="small text-body-secondary"><?= Html::encode($t->account->name) ?></td>
                                                                <td class="small text-body-secondary">
                                                                    <?= $t->relatedTransaction ? Html::encode($t->relatedTransaction->account->name) : '—' ?>
                                                                </td>
                                                                <td class="small text-body-secondary"><?= date('d M', strtotime($t->created_at)) ?></td>
                                                                <td class="text-end small fw-semibold text-warning">
                                                                    <?= number_format($t->amount, 2) ?> <?= $t->currency ?>
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
                            <script id="transferHistoryWeek" type="application/json">
                                <?= json_encode($transferHistory7) ?>
                            </script>
                            <script id="transferHistoryMonth" type="application/json">
                                <?= json_encode($transferHistory30) ?>
                            </script>
                            <div class="col-lg-6">
                                <div class="card col-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold"><?= Yii::t('app', 'Transfer Summary') ?></h6>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-sm transfer-range-btn chart-range-btn active" data-days="7">7d</button>
                                                <button class="btn btn-sm transfer-range-btn chart-range-btn" data-days="30">30d</button>
                                            </div>
                                        </div>
                                        <canvas id="transferChart" width="100%" height="40"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MONTHLY STATS -->
                <div class="row g-4 mt-1 mb-3">
                    <div class="col-md-4">
                        <div class="card col-card">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon-wrap stat-icon-income">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 15l-4 4l-4 -4" /></svg>
                                </div>
                                <div>
                                    <p class="stat-label"><?= Yii::t('app', 'Income this month') ?></p>
                                    <p class="stat-value text-success">
                                        +<?= number_format($monthlyStats['income'], 2) ?> <?= $user->preferred_currency ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card col-card">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon-wrap stat-icon-expense">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 9l-4 -4l-4 4" /></svg>
                                </div>
                                <div>
                                    <p class="stat-label"><?= Yii::t('app', 'Expenses this month') ?></p>
                                    <p class="stat-value text-danger">
                                        -<?= number_format($monthlyStats['expense'], 2) ?> <?= $user->preferred_currency ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card col-card">
                            <div class="card-body d-flex align-items-center gap-3">
                                <div class="stat-icon-wrap stat-icon-transfer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16l-4 -4l4 -4" /><path d="M3 12h18" /><path d="M17 8l4 4l-4 4" /></svg>
                                </div>
                                <div>
                                    <p class="stat-label"><?= Yii::t('app', 'Transferred this month') ?></p>
                                    <p class="stat-value" style="color: var(--accent)">
                                        <?= number_format($monthlyStats['transfers'], 2) ?> <?= $user->preferred_currency ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php endif; ?>
                
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
                            'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                            </span>{input}{error}</div>',
                        ])->textInput([
                            'placeholder' => 'e.g. Revolut EUR',
                            'class'       => 'form-control',
                        ]) ?>
                        </div>
            
                        <div class="mb-3">
                            <?= $form->field($accountModel, 'currency', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg width="20px" height="20px" viewBox="0 0 128 128" fill="var(--accent)" stroke="var(--accent)" stroke-width="2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="var(--accent)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M89 105.16s-.01 3.76-.01 4.22s2.05 1.44 5.76 1.48s5.84-.9 5.84-1.23s-.03-4.41-.03-4.41s-2.69-2.61-5.12-2.67s-6.44 2.61-6.44 2.61z" fill="var(--accent)"></path><path d="M25.87 3.13c-1.04.01-1.57.11-1.57 2.47s.22 74.85.22 75.64c0 .79.79 1.12 2.14 1.12h5.51c.9 0 1.24-.56 1.12-2.02s-.13-74.62-.13-75.52s-.41-1.6-1.84-1.65c-1.17-.04-4.22-.05-5.45-.04z" fill="var(--accent)"></path><path d="M16.41 29.6s-.16-4.12 2.74-6.78c2.68-2.45 5.17-2.27 5.17-2.27l.02 4.08s1.52-.53 4.1-.42s4.7 1 4.7 1v-4.28s1.43-.06 3.58 2.47c1.08 1.27 1.97 3.91 2.26 5.29c.38 1.77 1.03 2.6 2.74 2.72c1.71.12 3.02.11 4.07.07c1.51-.05-3.21-8.25-3.21-8.25s-5.27-7.96-6.99-8.01c-1.72-.05-12.37.22-13.39.75c-1.02.54-7.69 5.22-7.69 5.22l-.91 7.26s2.53 2.96 2.53 2.74c.02-.19.28-1.59.28-1.59z" fill="var(--accent)"></path><path d="M11.3 29.6l-5.02-3.95s-1.07 8.14 2.99 13.04c2.97 3.59 6.45 5.06 9.52 6.4c2.86 1.26 5.63 2.12 5.63 2.12l.01 4.81l8.78 4.67l-.01-6.31s3.33 1.81 5 3.59c1.67 1.77 1.83 3.98 1.88 5.38c.05 1.4-.65 3.6-.65 3.6l-.97 4.3l11.19-11.29l-26.4-17.53L11.3 29.6z" fill="var(--accent)"></path><path d="M6.88 54.85S5.54 56 5.93 59.12c.36 2.9 1.99 7.42 6.88 11.4s11.7 4.74 11.7 4.74v3.32l8.74-.02l-.01-3.3s5.22-.22 9.63-3.02c4.61-2.93 7.99-8.9 7.79-14.5c-.07-1.97-1.32-1.66-1.32-1.66S33.3 69.99 32.23 70.1c-1.08.11-11.51-1.72-11.51-1.72l-9.73-10.59l-4.11-2.94z" fill="var(--accent)"></path><path d="M10.98 53.69c-3.27.32-4.41.97-4.46 1.94c-.05.97 2.8 17.87 22.69 17.59c19.09-.27 21.35-11.88 21.51-16.4c.19-5.43-3.01-9.95-10.22-14.2c-5.37-3.16-18.34-7.91-20.49-9.25c-1.98-1.24-4.73-3.98-4.36-8.07c.38-4.09 4.84-8.12 13.07-8.07c8.23.05 11.47 5.78 12.1 7.48c1.01 2.73.82 6.28 2.31 6.75c.7.22 2.74.13 3.92-.03c1.18-.16 2.86-1.07 2.96-3.44c.11-2.74-2.74-18.07-21.78-17.91c-18.18.15-22.65 11.3-21.95 17.7c.66 6.07 5.6 11.77 13.56 15s22.05 7.15 21.89 14.41c-.14 6.51-7.7 8.82-13.93 8.5c-6.29-.32-9.73-3.98-11.02-8.28c-1.23-4.13-3.59-3.93-5.8-3.72z" fill="var(--accent)"></path><path d="M14 55.75c-.67-1.25-5.15-1.06-5.73 1.06s1.47 5.41 2.85 5.12c1.88-.39.29-2.66 1.02-3.52c.74-.87 2.69-1.11 1.86-2.66z" fill="var(--accent)"></path><path d="M28.4 4.25c-1.31-.03-2.78-.05-2.85 1.72c-.07 1.7.04 3.01.71 3.08c.75.08 1.81-1.54 2.27-2.24c.57-.89 1.28-2.52-.13-2.56z" fill="var(--accent)"></path><path d="M18.35 14.62c-.5-.73-3.31-1.31-7.19 3.48s-2.45 7.33-1.56 7.44c1.21.15 1.88-.84 2.62-2.47c1.06-2.32 2.32-3.73 4.29-5.22c1.68-1.27 2.7-1.97 1.84-3.23z" fill="var(--accent)"></path><path d="M74.01 84.47v1.79c0 .6.51 1.09 1.73 1.14c1.22.05 38.59.1 38.81.08c.38-.04.39-.49.39-.77c.03-1.1.02-2.23.02-2.23L79.9 82.64l-5.89 1.83z" fill="var(--accent)"></path><path d="M74.02 94.71v2.86c.01.53.42.63 1.17.64h38.36c.54 0 .97-.31.99-.91c.03-.82.01-2.59.01-2.59l-20.21-2.13l-20.32 2.13z" fill="var(--accent)"></path><path fill="var(--accent)" d="M74 79.85h40.96v4.66H74z"></path><path fill="var(--accent)" d="M74.01 90.39h40.55v4.35H74.01z"></path><path d="M89 105.16l.52-25.33S66.29 45.01 66.55 44.48c.27-.53 13.7-.28 14.37.12c.67.4 13.91 21.31 14.49 21.3c.6-.01 13.22-20.56 13.75-20.96c.53-.4 14.29-.52 14.29.02s-22.98 34.93-22.98 34.93l.09 25.41s-3.52.23-5.78.23s-5.78-.37-5.78-.37z" fill="var(--accent)"></path><path d="M79.13 46.83c.03.71-4.02 4.62-4.82 4.62c-.8 0-2.83-2.73-3.27-4.32c-.3-1.08 3.16-1.27 4.48-1.27c1.33.01 3.57.05 3.61.97z" fill="var(--accent)"></path><path d="M110.55 47.08c-.43.26-4.17 4.49-2.52 5.81c1.17.94 3.52-1.35 5.32-2.15c1.8-.8 4.77-1.46 4.74-2.94c-.04-1.82-5.97-1.68-7.54-.72z" fill="var(--accent)"></path><path d="M54.67 16.64c1.03 1.41 5.05-.66 8.44-1.16c3.39-.5 8.94-1.41 17.13 2.48s12.99 9.52 12.91 9.93c-.08.41-7.61 2.37-9.76 3.45c-1.8.9-2.55 2.16-2.24 3.67c.29 1.43 1.42 2.2 3.07 2.61c2.88.72 22.73 2.65 25.71-.17c3.74-3.53 2.79-22.18 2.56-24.38c-.34-3.37-1.28-4.51-2.98-4.79c-1.49-.25-2.98.41-3.89 2.67c-1.03 2.54-2.8 8.99-3.3 8.99s-5.86-8.1-15.38-11.41s-17.95-1.82-23 .08c-5.4 2.04-10.59 6.21-9.27 8.03z" fill="var(--accent)"></path><path d="M42.34 103.09c-.33.44 4.19 8.2 14.03 11.11s21.33-2.27 22.59.18c1.64 3.19-12.35 13.85-29.6 8.11c-14.48-4.82-16.85-14.12-17.3-14.03s-3.98 4.67-4.92 5.74c-2.2 2.5-7.38 1-6.01-3.73c1.85-6.42 6.75-20.99 9.38-21.95c3.52-1.29 20.95 7.37 22.22 8.11c2.37 1.37 2.91 5.65-1.37 5.92c-2.64.16-8.74.18-9.02.54z" fill="var(--accent)"></path></g></svg>
                                </span>{input}{error}</div>',
                            ])->dropDownList(
                                Account::currencyList(),
                                ['class' => 'form-select']
                            ) ?>
                        </div>
            
                        <div class="mb-3">
                            <?= $form->field($accountModel, 'type', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                                </span>{input}{error}</div>',
                            ])->dropDownList(
                                Account::typeList(),
                                ['class' => 'form-select']
                            ) ?>
                        </div>
            
                        <div class="mb-4">
                            <?= $form->field($accountModel, 'balance', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                                </span>{input}{error}</div>',
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
                                'class' => 'btn btn-accent w-100 rounded-3 text-white',
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
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                                </span>{input}{error}</div>',
                                ])->textInput([
                                'class' => 'form-control',
                                'id'    => 'edit-account-name',
                                ]) ?>
                            </div>
            
                            <div class="mb-3">
                                <?= $editForm->field($editAccountModel, 'currency', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg width="20px" height="20px" viewBox="0 0 128 128" fill="var(--accent)" stroke="var(--accent)" stroke-width="2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--noto" preserveAspectRatio="xMidYMid meet" fill="var(--accent)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M89 105.16s-.01 3.76-.01 4.22s2.05 1.44 5.76 1.48s5.84-.9 5.84-1.23s-.03-4.41-.03-4.41s-2.69-2.61-5.12-2.67s-6.44 2.61-6.44 2.61z" fill="var(--accent)"></path><path d="M25.87 3.13c-1.04.01-1.57.11-1.57 2.47s.22 74.85.22 75.64c0 .79.79 1.12 2.14 1.12h5.51c.9 0 1.24-.56 1.12-2.02s-.13-74.62-.13-75.52s-.41-1.6-1.84-1.65c-1.17-.04-4.22-.05-5.45-.04z" fill="var(--accent)"></path><path d="M16.41 29.6s-.16-4.12 2.74-6.78c2.68-2.45 5.17-2.27 5.17-2.27l.02 4.08s1.52-.53 4.1-.42s4.7 1 4.7 1v-4.28s1.43-.06 3.58 2.47c1.08 1.27 1.97 3.91 2.26 5.29c.38 1.77 1.03 2.6 2.74 2.72c1.71.12 3.02.11 4.07.07c1.51-.05-3.21-8.25-3.21-8.25s-5.27-7.96-6.99-8.01c-1.72-.05-12.37.22-13.39.75c-1.02.54-7.69 5.22-7.69 5.22l-.91 7.26s2.53 2.96 2.53 2.74c.02-.19.28-1.59.28-1.59z" fill="var(--accent)"></path><path d="M11.3 29.6l-5.02-3.95s-1.07 8.14 2.99 13.04c2.97 3.59 6.45 5.06 9.52 6.4c2.86 1.26 5.63 2.12 5.63 2.12l.01 4.81l8.78 4.67l-.01-6.31s3.33 1.81 5 3.59c1.67 1.77 1.83 3.98 1.88 5.38c.05 1.4-.65 3.6-.65 3.6l-.97 4.3l11.19-11.29l-26.4-17.53L11.3 29.6z" fill="var(--accent)"></path><path d="M6.88 54.85S5.54 56 5.93 59.12c.36 2.9 1.99 7.42 6.88 11.4s11.7 4.74 11.7 4.74v3.32l8.74-.02l-.01-3.3s5.22-.22 9.63-3.02c4.61-2.93 7.99-8.9 7.79-14.5c-.07-1.97-1.32-1.66-1.32-1.66S33.3 69.99 32.23 70.1c-1.08.11-11.51-1.72-11.51-1.72l-9.73-10.59l-4.11-2.94z" fill="var(--accent)"></path><path d="M10.98 53.69c-3.27.32-4.41.97-4.46 1.94c-.05.97 2.8 17.87 22.69 17.59c19.09-.27 21.35-11.88 21.51-16.4c.19-5.43-3.01-9.95-10.22-14.2c-5.37-3.16-18.34-7.91-20.49-9.25c-1.98-1.24-4.73-3.98-4.36-8.07c.38-4.09 4.84-8.12 13.07-8.07c8.23.05 11.47 5.78 12.1 7.48c1.01 2.73.82 6.28 2.31 6.75c.7.22 2.74.13 3.92-.03c1.18-.16 2.86-1.07 2.96-3.44c.11-2.74-2.74-18.07-21.78-17.91c-18.18.15-22.65 11.3-21.95 17.7c.66 6.07 5.6 11.77 13.56 15s22.05 7.15 21.89 14.41c-.14 6.51-7.7 8.82-13.93 8.5c-6.29-.32-9.73-3.98-11.02-8.28c-1.23-4.13-3.59-3.93-5.8-3.72z" fill="var(--accent)"></path><path d="M14 55.75c-.67-1.25-5.15-1.06-5.73 1.06s1.47 5.41 2.85 5.12c1.88-.39.29-2.66 1.02-3.52c.74-.87 2.69-1.11 1.86-2.66z" fill="var(--accent)"></path><path d="M28.4 4.25c-1.31-.03-2.78-.05-2.85 1.72c-.07 1.7.04 3.01.71 3.08c.75.08 1.81-1.54 2.27-2.24c.57-.89 1.28-2.52-.13-2.56z" fill="var(--accent)"></path><path d="M18.35 14.62c-.5-.73-3.31-1.31-7.19 3.48s-2.45 7.33-1.56 7.44c1.21.15 1.88-.84 2.62-2.47c1.06-2.32 2.32-3.73 4.29-5.22c1.68-1.27 2.7-1.97 1.84-3.23z" fill="var(--accent)"></path><path d="M74.01 84.47v1.79c0 .6.51 1.09 1.73 1.14c1.22.05 38.59.1 38.81.08c.38-.04.39-.49.39-.77c.03-1.1.02-2.23.02-2.23L79.9 82.64l-5.89 1.83z" fill="var(--accent)"></path><path d="M74.02 94.71v2.86c.01.53.42.63 1.17.64h38.36c.54 0 .97-.31.99-.91c.03-.82.01-2.59.01-2.59l-20.21-2.13l-20.32 2.13z" fill="var(--accent)"></path><path fill="var(--accent)" d="M74 79.85h40.96v4.66H74z"></path><path fill="var(--accent)" d="M74.01 90.39h40.55v4.35H74.01z"></path><path d="M89 105.16l.52-25.33S66.29 45.01 66.55 44.48c.27-.53 13.7-.28 14.37.12c.67.4 13.91 21.31 14.49 21.3c.6-.01 13.22-20.56 13.75-20.96c.53-.4 14.29-.52 14.29.02s-22.98 34.93-22.98 34.93l.09 25.41s-3.52.23-5.78.23s-5.78-.37-5.78-.37z" fill="var(--accent)"></path><path d="M79.13 46.83c.03.71-4.02 4.62-4.82 4.62c-.8 0-2.83-2.73-3.27-4.32c-.3-1.08 3.16-1.27 4.48-1.27c1.33.01 3.57.05 3.61.97z" fill="var(--accent)"></path><path d="M110.55 47.08c-.43.26-4.17 4.49-2.52 5.81c1.17.94 3.52-1.35 5.32-2.15c1.8-.8 4.77-1.46 4.74-2.94c-.04-1.82-5.97-1.68-7.54-.72z" fill="var(--accent)"></path><path d="M54.67 16.64c1.03 1.41 5.05-.66 8.44-1.16c3.39-.5 8.94-1.41 17.13 2.48s12.99 9.52 12.91 9.93c-.08.41-7.61 2.37-9.76 3.45c-1.8.9-2.55 2.16-2.24 3.67c.29 1.43 1.42 2.2 3.07 2.61c2.88.72 22.73 2.65 25.71-.17c3.74-3.53 2.79-22.18 2.56-24.38c-.34-3.37-1.28-4.51-2.98-4.79c-1.49-.25-2.98.41-3.89 2.67c-1.03 2.54-2.8 8.99-3.3 8.99s-5.86-8.1-15.38-11.41s-17.95-1.82-23 .08c-5.4 2.04-10.59 6.21-9.27 8.03z" fill="var(--accent)"></path><path d="M42.34 103.09c-.33.44 4.19 8.2 14.03 11.11s21.33-2.27 22.59.18c1.64 3.19-12.35 13.85-29.6 8.11c-14.48-4.82-16.85-14.12-17.3-14.03s-3.98 4.67-4.92 5.74c-2.2 2.5-7.38 1-6.01-3.73c1.85-6.42 6.75-20.99 9.38-21.95c3.52-1.29 20.95 7.37 22.22 8.11c2.37 1.37 2.91 5.65-1.37 5.92c-2.64.16-8.74.18-9.02.54z" fill="var(--accent)"></path></g></svg>
                                </span>{input}{error}</div>',
                                ])->dropDownList(
                                Account::currencyList(),
                                ['class' => 'form-select', 'id' => 'edit-account-currency']
                                ) ?>
                            </div>
            
                            <div class="mb-3">
                                <?= $editForm->field($editAccountModel, 'type', [
                                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" /></svg>
                                    </span>{input}{error}</div>',
                                ])->dropDownList(
                                    Account::typeList(),
                                    ['class' => 'form-select', 'id' => 'edit-account-type']
                                ) ?>
                            </div>
            
                            <div class="mb-4">
                                <?= $editForm->field($editAccountModel, 'balance', [
                                'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                                </span>{input}{error}</div>',
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
                                        'class' => 'btn btn-accent w-100 rounded-3 text-white',
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

        </div>
        
    </div>  
</div>