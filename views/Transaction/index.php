<?php
/** @var yii\web\View $this */
/** @var app\models\Transaction[] $transactions */
/** @var app\models\Transaction $editTransactionModel */
/** @var app\models\Account[] $accounts */

use app\models\Account;
use app\models\Transaction;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Transactions');
$this->params['showFab'] = true;
$this->params['pageJs']  = ['finance'];
$this->params['layout'] = 'dashboard';
?>

<div class="user-dashboard">
    <div class="container">
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
                <?= $this->render('..\layouts\_account_card', ['account' => $account]) ?>
            <?php endforeach; ?>
        </div>

        <!-- Desktop carousel -->
        <div class="accounts-carousel-wrapper">
            <?php if(!empty($accounts)): ?>
                <button class="accounts-nav-btn accounts-nav-prev" id="accounts-prev" aria-label="Previous">&#8592;</button>
            <?php endif; ?>
            <div class="accounts-carousel" id="accounts-carousel">
                <?php foreach ($accounts as $account): ?>
                    <?= $this->render('..\layouts\_account_card', ['account' => $account]) ?>
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
            <hr style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
            <div class="transactions-page-divide">
                <div class="transactions-table">
                    <!-- Main card -->
                    <div class="card col-card">
                        <div class="card-body p-0">

                            <!-- Filters header -->
                            <div class="transaction-filters-header p-3 pb-0">

                                <!-- Preset buttons -->
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
                                    <?php
                                    $presets = [
                                        'all'        => Yii::t('app', 'All time'),
                                        'this_month' => Yii::t('app', 'This month'),
                                        'last_month' => Yii::t('app', 'Last month'),
                                        'last_7'     => Yii::t('app', 'Last 7 days'),
                                        'this_year'  => Yii::t('app', 'This year'),
                                    ];
                                    foreach ($presets as $key => $label):
                                        $active = ($preset === $key) || ($key === 'all' && !$preset && !$from && !$to);
                                    ?>
                                        <a href="<?= Url::current(['preset' => $key, 'from' => null, 'to' => null, 'page' => null]) ?>"
                                        class="btn btn-sm <?= $active ? 'btn-accent' : 'btn-outline-secondary' ?>">
                                            <?= $label ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Search + custom date row -->
                                <form method="get" action="<?= Url::toRoute(['transaction/index']) ?>" class="transaction-filter-form mb-3">
                                    <input type="hidden" name="preset" value="">
                                    <div class="row g-2 align-items-end">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label small fw-semibold mb-1"><?= Yii::t('app', 'Search') ?></label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                </span>
                                                <input type="text" name="q" value="<?= Html::encode($q) ?>"
                                                    class="form-control form-control-sm"
                                                    placeholder="<?= Yii::t('app', 'Note, account, amount...') ?>">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label small fw-semibold mb-1"><?= Yii::t('app', 'From') ?></label>
                                            <input type="date" name="from" value="<?= Html::encode($from) ?>"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label class="form-label small fw-semibold mb-1"><?= Yii::t('app', 'To') ?></label>
                                            <input type="date" name="to" value="<?= Html::encode($to) ?>"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-12 col-md-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-accent btn-sm flex-grow-1">
                                                <?= Yii::t('app', 'Apply') ?>
                                            </button>
                                            <?php if ($q || $from || $to): ?>
                                                <a href="<?= Url::toRoute(['transaction/index']) ?>" class="btn btn-outline-secondary btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>

                                <!-- Results count + active filters -->
                                <div class="d-flex align-items-center justify-content-between pb-2 border-bottom">
                                    <p class="small text-body-secondary mb-0">
                                        <?= number_format($totalCount) ?> <?= Yii::t('app', 'transactions') ?>
                                        <?php if ($from || $to): ?>
                                            <span class="ms-2 transaction-type-badge transaction-badge-transfer">
                                                <?= $from ? Html::encode($from) : '…' ?> → <?= $to ? Html::encode($to) : '…' ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($q): ?>
                                            <span class="ms-1 transaction-type-badge" style="background: var(--bs-tertiary-bg); color: var(--bs-secondary-color);">
                                                "<?= Html::encode($q) ?>"
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>

                            </div>

                            <!-- Table -->
                            <?php if (empty($transactions)): ?>
                                <div class="p-4">
                                    <p class="text-body-secondary small mb-0"><?= Yii::t('app', 'No transactions found.') ?></p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0 table-transactions" id="transactions-table">
                                        <thead>
                                            <tr class="text-body-secondary small">
                                                <th class="ps-4"><?= Yii::t('app', 'Note') ?></th>
                                                <th><?= Yii::t('app', 'Account') ?></th>
                                                <th><?= Yii::t('app', 'Type') ?></th>
                                                <th><?= Yii::t('app', 'Date') ?></th>
                                                <th class="text-end"><?= Yii::t('app', 'Amount') ?></th>
                                                <th class="text-end pe-4"><?= Yii::t('app', 'Actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $t): ?>
                                                <tr>
                                                    <td class="ps-4 small"><?= Html::encode($t->note ?: '—') ?></td>
                                                    <td class="small text-body-secondary">
                                                        <?= Html::encode($t->account->name ?? '—') ?>
                                                        <?php if ($t->type === 'transfer_out' && $t->relatedTransaction): ?>
                                                            <span class="text-body-secondary"> → <?= Html::encode($t->relatedTransaction->account->name) ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php $typeClass = match($t->type) {
                                                            'income'       => 'transaction-badge-income',
                                                            'expense'      => 'transaction-badge-expense',
                                                            'transfer_out',
                                                            'transfer_in'  => 'transaction-badge-transfer',
                                                            default        => '',
                                                        }; ?>
                                                        <span class="transaction-type-badge <?= $typeClass ?>">
                                                            <?= Html::encode(Transaction::typeList()[$t->type] ?? $t->type) ?>
                                                        </span>
                                                    </td>
                                                    <td class="small text-body-secondary">
                                                        <?= $t->transaction_date ? date('d M Y', strtotime($t->transaction_date)) : date('d M Y', strtotime($t->created_at)) ?>
                                                    </td>
                                                    <td class="text-end small fw-semibold <?= $t->isCredit() ? 'text-success' : ($t->type === 'transfer_out' ? 'text-warning' : 'text-danger') ?>">
                                                        <?= $t->isCredit() ? '+' : ($t->type === 'transfer_out' ? '' : '-') ?><?= number_format($t->amount, 2) ?> <?= $t->currency ?>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <?php if ($t->type !== 'transfer_in'): ?>
                                                                <button class="btn btn-sm btn-outline-secondary edit-transaction-btn"
                                                                    data-id="<?= $t->id ?>"
                                                                    data-account="<?= $t->account_id ?>"
                                                                    data-type="<?= $t->type ?>"
                                                                    data-amount="<?= $t->amount ?>"
                                                                    data-note="<?= Html::encode($t->note) ?>"
                                                                    data-date="<?= $t->transaction_date ?? date('Y-m-d', strtotime($t->created_at)) ?>"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editTransactionModal">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" /><path d="M16 5l3 3" /></svg>
                                                                </button>
                                                            <?php endif; ?>
                                                            <button class="btn btn-sm btn-outline-danger delete-transaction-btn"
                                                                data-id="<?= $t->id ?>"
                                                                data-note="<?= Html::encode($t->note ?: Yii::t('app', 'this transaction')) ?>"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteTransactionModal">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if ($pagination->pageCount > 1): ?>
                                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
                                        <p class="small text-body-secondary mb-0">
                                            <?= Yii::t('app', 'Page') ?> <?= $pagination->page + 1 ?> <?= Yii::t('app', 'of') ?> <?= $pagination->pageCount ?>
                                        </p>
                                        <div class="d-flex gap-1">
                                            <?php if ($pagination->page > 0): ?>
                                                <a href="<?= Url::current(['page' => $pagination->page]) ?>"
                                                class="btn btn-sm btn-outline-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                                                </a>
                                            <?php endif; ?>

                                            <?php
                                            $currentPage = $pagination->page;
                                            $totalPages  = $pagination->pageCount;
                                            $range       = 2;
                                            $start       = max(0, $currentPage - $range);
                                            $end         = min($totalPages - 1, $currentPage + $range);
                                            ?>

                                            <?php if ($start > 0): ?>
                                                <a href="<?= Url::current(['page' => 1]) ?>" class="btn btn-sm btn-outline-secondary">1</a>
                                                <?php if ($start > 1): ?><span class="btn btn-sm disabled">…</span><?php endif; ?>
                                            <?php endif; ?>

                                            <?php for ($i = $start; $i <= $end; $i++): ?>
                                                <a href="<?= Url::current(['page' => $i + 1]) ?>"
                                                class="btn btn-sm <?= $i === $currentPage ? 'btn-accent' : 'btn-outline-secondary' ?>">
                                                    <?= $i + 1 ?>
                                                </a>
                                            <?php endfor; ?>

                                            <?php if ($end < $totalPages - 1): ?>
                                                <?php if ($end < $totalPages - 2): ?><span class="btn btn-sm disabled">…</span><?php endif; ?>
                                                <a href="<?= Url::current(['page' => $totalPages]) ?>" class="btn btn-sm btn-outline-secondary"><?= $totalPages ?></a>
                                            <?php endif; ?>

                                            <?php if ($pagination->page < $pagination->pageCount - 1): ?>
                                                <a href="<?= Url::current(['page' => $pagination->page + 2]) ?>"
                                                class="btn btn-sm btn-outline-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                    </div>

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
                </div>
                <div class="transactions-widgets">
                    <!-- Set expenses limit -->
                    <?php
                        $remainingMoney = 0;
                        $percentage = 0;

                        if ($monthlyLimit !== null && $monthlyLimit->budget_limit > 0) {
                            $remainingMoney = max(0, $monthlyLimit->budget_limit - $monthlyStats['expense']);
                            $percentage = min($monthlyStats['expense'] / $monthlyLimit->budget_limit, 1);
                        }
                        $dashOffset = 100 * $percentage;
                    ?>
                    <div class="card col-card mb-4">
                        <div class="card-body limit-card-body" style="padding-bottom: 0">
                            <h3 class="transaction-widget-title"><?= Yii::t('app', 'Monthly Limit') ?></h3>
                            <svg viewBox="0 0 220 120">
                                <!-- Progress -->
                                <path
                                    class="gauge-gray"
                                    d="M20 110 A90 90 0 0 1 200 110"
                                />
                                <path
                                    class="gauge-progress"
                                    pathLength="100"
                                    d="M20 110 A90 90 0 0 1 200 110"
                                    style="stroke-dashoffset: <?= $dashOffset ?>"
                                />
                                <?php if ($monthlyLimit === null || $monthlyLimit->budget_limit == 0): ?>
                                    <text
                                        x="110"
                                        y="95"
                                        text-anchor="middle"
                                        class="gauge-value no-limit-set-value">
                                        <?= Yii::t('app', 'No budget set') ?>
                                    </text>
                                <?php else: ?>
                                    <text
                                        x="110"
                                        y="90"
                                        text-anchor="middle"
                                        class="gauge-value">
                                        <?= number_format($remainingMoney, 0) ?> <?= $user->preferred_currency ?>
                                    </text>
                                    <text
                                        x="110"
                                        y="108"
                                        text-anchor="middle"
                                        class="gauge-subtitle">
                                        <?= Yii::t('app', 'remaining') ?>
                                    </text>

                                <?php endif; ?>
                            </svg>
                            <hr>
                            <?php
                                $limitForm = ActiveForm::begin([
                                    'id' => 'form-limit-transactions',
                                    'action' => ['transaction/update-limit'],
                                ]);?>
                                <div class="mb-3">
                                    <?= $limitForm->field($monthlyLimit, 'budget_limit', [
                                        'template' => 
                                            '<div class="input-group">
                                                <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg></span>
                                                {input}
                                                <button class="btn btn-accent" type="submit">
                                                    Save
                                                </button>
                                            </div>
                                            {error}',
                                    ])->textInput([
                                        'type'  => 'number',
                                        'step'  => '0.01',
                                        'min'   => '0.01',
                                        'class' => 'form-control',
                                        'id'    => 'edit-transaction-amount',
                                    ]) ?>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="card-body monthly-stat monthly-stat-income d-flex align-items-center gap-3">
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
                        <div class="card-body monthly-stat d-flex align-items-center gap-3">
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
                        <div class="card-body monthly-stat monthly-stat-transfer d-flex align-items-center gap-3">
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

        <!-- Edit Transaction Modal -->
        <div class="modal fade" id="editTransactionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-4 p-lg-5">

                        <div class="text-center mb-4">
                            <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Edit Transaction') ?></h1>
                            <p class="text-body-secondary small"><?= Yii::t('app', 'Update transaction details') ?></p>
                        </div>

                        <?php $editForm = ActiveForm::begin([
                            'id'     => 'form-edit-transaction',
                            'action' => ['transaction/update'],
                        ]); ?>

                            <?= Html::hiddenInput('id', '', ['id' => 'edit-transaction-id']) ?>

                            <div class="mb-3">
                                <?= $editForm->field($editTransactionModel, 'account_id', [
                                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg></span>{input}{error}</div>',
                                ])->dropDownList(
                                    ArrayHelper::map($accounts, 'id', 'name'),
                                    ['class' => 'form-select', 'id' => 'edit-transaction-account', 'prompt' => Yii::t('app', 'Select account')]
                                ) ?>
                            </div>

                            <div class="mb-3">
                                <?= $editForm->field($editTransactionModel, 'amount', [
                                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 6v2m0 8v2" /></svg></span>{input}{error}</div>',
                                ])->textInput([
                                    'type'  => 'number',
                                    'step'  => '0.01',
                                    'min'   => '0.01',
                                    'class' => 'form-control',
                                    'id'    => 'edit-transaction-amount',
                                ]) ?>
                            </div>

                            <div class="mb-3">
                                <?= $editForm->field($editTransactionModel, 'note', [
                                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" /><path d="M13 8l2 0" /><path d="M13 12l2 0" /></svg></span>{input}{error}</div>',
                                ])->textInput([
                                    'class'       => 'form-control',
                                    'id'          => 'edit-transaction-note',
                                    'placeholder' => Yii::t('app', 'Optional note'),
                                ]) ?>
                            </div>

                            <div class="mb-4">
                                <?= $editForm->field($editTransactionModel, 'transaction_date', [
                                    'template' => '<label class="form-label small fw-semibold">{label}</label><div class="input-group"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /></svg></span>{input}{error}</div>',
                                ])->textInput([
                                    'type'  => 'date',
                                    'class' => 'form-control',
                                    'id'    => 'edit-transaction-date',
                                ])->label(Yii::t('app', 'Transaction Date')) ?>
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

        <!-- Delete Transaction Modal -->
        <div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-4 p-lg-5 text-center">

                        <p class="fs-1 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                        </p>
                        <h1 class="h3 fw-bold mb-1"><?= Yii::t('app', 'Delete Transaction') ?></h1>
                        <p class="text-body-secondary small mb-4">
                            <?= Yii::t('app', 'Are you sure you want to delete') ?>
                            <b id="delete-transaction-note"></b>?
                            <br>
                            <?= Yii::t('app', 'This will reverse the effect on your account balance.') ?>
                        </p>

                        <?php $deleteForm = ActiveForm::begin([
                            'id'     => 'form-delete-transaction',
                            'action' => ['transaction/delete'],
                        ]); ?>

                            <?= Html::hiddenInput('id', '', ['id' => 'delete-transaction-id']) ?>

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