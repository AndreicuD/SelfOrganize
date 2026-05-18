<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

$this->render('_head');
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


<?php
$this->registerJsFile(
    Yii::$app->request->baseUrl . '/js/accent.js',
    ['position' => \yii\web\View::POS_HEAD]
);
$this->registerJsFile(
    Yii::$app->request->baseUrl . '/js/dashboard.js',
    ['position' => \yii\web\View::POS_HEAD]
);

$this->registerJsFile(
    'https://cdn.jsdelivr.net/npm/chart.js',
    ['position' => \yii\web\View::POS_HEAD]
);

$this->registerJsFile(
    Yii::$app->request->baseUrl . '/js/finance.js',
    [
        'position' => \yii\web\View::POS_END,
        'depends'  => [\yii\web\JqueryAsset::class],
    ]
);

$this->registerJsFile(
    Yii::$app->request->baseUrl . '/js/fab.js',
    ['position' => \yii\web\View::POS_END]
);
?>

</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= $this->render('_header') ?>

<main id="main" class="user-dashboard" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?= $this->render('_footer') ?>

<?php $this->endBody() ?>

<?php
use app\models\Transaction;
use app\models\Account;

$transactionModel = new Transaction();
$fabAccounts = Account::getByUser(Yii::$app->user->id);
?>

<?= $this->render('//layouts/_fab_modals', [
    'transactionModel' => $transactionModel,
    'accounts'         => $fabAccounts,
]) ?>

<!-- FAB -->
<?= $this->render('//layouts/_fab') ?>

</body>
</html>
<?php $this->endPage() ?>
