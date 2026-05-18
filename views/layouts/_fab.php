<!-- FAB -->
<div class="fab-container">
    <div class="fab-menu" id="fabMenu">
        <div class="fab-menu-item" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <span class="fab-menu-label"><?= Yii::t('app', 'Add Expense') ?></span>
            <button class="fab-action-btn fab-expense">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 15l-4 4l-4 -4" /></svg>
            </button>
        </div>
        <div class="fab-menu-item" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
            <span class="fab-menu-label"><?= Yii::t('app', 'Add Income') ?></span>
            <button class="fab-action-btn fab-income">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M16 9l-4 -4l-4 4" /></svg>
            </button>
        </div>
        <div class="fab-menu-item" data-bs-toggle="modal" data-bs-target="#addTransferModal">
            <span class="fab-menu-label"><?= Yii::t('app', 'Transfer') ?></span>
            <button class="fab-action-btn fab-transfer">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 16l-4 -4l4 -4" /><path d="M3 12h18" /><path d="M17 8l4 4l-4 4" /></svg>
            </button>
        </div>
        <div class="fab-menu-item" data-bs-toggle="modal" data-bs-target="#addTaskModal">
            <span class="fab-menu-label"><?= Yii::t('app', 'Add Task') ?></span>
            <button class="fab-action-btn fab-task">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
            </button>
        </div>
    </div>

    <button class="fab-main" id="fabMain" aria-label="Quick actions">
        <svg id="fabIconPlus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
        <svg id="fabIconClose" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
    </button>
</div>