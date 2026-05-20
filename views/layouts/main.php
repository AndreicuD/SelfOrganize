<?php
declare(strict_types=1);
/** @var yii\web\View $this */
/** @var string $content */
use app\widgets\Alert;
use app\models\Transaction;
use app\models\Account;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

$this->render('_head');

$availableJs = [
    'finance'   => '/js/finance.js',
    'dashboard' => '/js/dashboard.js',
    'chart' => 'https://cdn.jsdelivr.net/npm/chart.js',
];

//always load
$this->registerJsFile(
    Yii::$app->request->baseUrl . '/js/accent.js',
    ['position' => \yii\web\View::POS_HEAD]
);

// Load page-specific JS files requested by the view
$pageJs = $this->params['pageJs'] ?? [];
foreach ($pageJs as $key) {
    if (isset($availableJs[$key])) {
        $this->registerJsFile(
            Yii::$app->request->baseUrl . $availableJs[$key],
            ['position' => \yii\web\View::POS_HEAD]
        );
    }
}

// Load FAB JS only if the view requests it
if (!empty($this->params['showFab']) && !Yii::$app->user->isGuest) {
    $this->registerJsFile(
        Yii::$app->request->baseUrl . '/js/fab.js',
        ['position' => \yii\web\View::POS_END]
    );
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">
<head>
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:ital,wght@0,300..800;1,300..800&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= $this->render('_header') ?>

<?php if(empty($this->params['layout'])): ?>
<main id="main" class="flex-grow-1" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<?php elseif($this->params['layout'] == "dashboard"): ?>
<main id="main" class="user-dashboard" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<?php elseif($this->params['layout'] == 'hero'): ?>
<main id="main" class="flex-grow-1" role="main">
    <div class="index-layout">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>
<?php endif; ?>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>

<?php if (!empty($this->params['showFab']) && !Yii::$app->user->isGuest): ?>
    <?php
    $transactionModel = new Transaction();
    $fabAccounts      = Account::getByUser(Yii::$app->user->id);
    ?>
    <?= $this->render('//layouts/_fab_modals', [
        'transactionModel' => $transactionModel,
        'accounts'         => $fabAccounts,
    ]) ?>
    <?= $this->render('//layouts/_fab') ?>
<?php endif ?>

</body>
</html>
<?php $this->endPage() ?>