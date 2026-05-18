<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;

$items = [
    [
        'label' => 'Contact',
        'url' => ['/site/contact'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Dashboard',
        'url' => ['/dashboard/index'],
        'visible' => !Yii::$app->user->isGuest,
    ],
];

?>
<header id="header">
    <?php NavBar::begin(
        [
            'brandLabel' => Yii::$app->name,
            'brandOptions' => [
                'class' => 'inline-logo',
                'style' => 'font-size: 1.2em',
            ],
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ],
    ) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'encodeLabels' => false,
            'items' => $items,
        ],
    ) ?>
    <?php
        if (Yii::$app->user->isGuest) {
            echo "<div class='btn-group login_logoutbutton'>";
            
            echo Html::a('Login',['user/login'],['class' => ['btn btn-primary btn-loginlogout text-decoration-none']]);

            echo "</div>";
        }
        else {
            echo "<div class='btn-group login_logoutbutton'>";
            
            echo Html::a('Logout (' . Html::encode(Yii::$app->user->identity?->username ?? '') . ')',['user/logout'],['data-method' => 'post', 'class' => ['btn btn-primary btn-loginlogout text-decoration-none']]);

            echo "</div>";
        }
    ?>
    <?= Html::button(
        '&#127769;',
        [
            'id' => 'theme-toggle',
            'class' => 'btn btn-link nav-link fs-5',
            'aria-label' => 'Switch to dark mode',
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
