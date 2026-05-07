<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

?>
<footer id="footer" class="mt-auto py-3 footer-transparent">
    <div class="container">
        <div class="row footer-transparent-text">
            <div class="col-md-6 text-center text-md-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end">
                <?= Yii::t('app', 'Made with love by Huțanu Andrei ❤️') ?>
            </div>
        </div>
    </div>
</footer>
