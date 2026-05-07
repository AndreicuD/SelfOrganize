<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = Yii::$app->name;
$this->params['meta_description'] = 'A high-performance PHP organization app.';
$this->params['meta_keywords'] = 'organize, php, yii, self, self organize';
?>
<div class="site-index">

    <div class='hero'>
        <div class='hero-inside'>
            <p class='hero-title'><?= Yii::$app->name ?></p>
            <p class='hero-text'><?= Yii::t('app', 'Do you want to start getting your life together? Start right here, right now!') ?></p>
        </div>
        <!-- From Uiverse.io by Creatlydev --> 
        <button href="user/signup" class="cta-btn">
            <span class="button__icon-wrapper">
                <svg
                    viewBox="0 0 14 15"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    class="button__icon-svg"
                    width="10"
                >
                <path
                    d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                    fill="currentColor"
                ></path>
                </svg>

                <svg
                    viewBox="0 0 14 15"
                    fill="none"
                    width="10"
                    xmlns="http://www.w3.org/2000/svg"
                    class="button__icon-svg button__icon-svg--copy"
                >
                <path
                    d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"
                    fill="currentColor"
                ></path>
                </svg>
            </span>
            Sign Up
        </button>
        <?= Html::img(
            Yii::getAlias('@web/images/HeroFadeCropped.png'),
            [
                'alt' => 'Hero Background',
            ],
        ) ?>
        <?= Html::img(
            Yii::getAlias('@web/images/HeroFadePhone.png'),
            [
                'class' => 'hero-img-phone',
                'alt' => 'Hero Background',
            ],
        ) ?>
    </div>

</div>
