<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::$app->name;
$this->params['meta_description'] = 'A high-performance PHP life organization app.';
$this->params['meta_keywords'] = 'organize, php, yii, self, self organize';

$this->params['layout'] = 'hero';
?>
<div class="site-index">

    <div class='hero user-select-none'>
        <div class='hero-inside'>
            <p class='hero-title'><?= Yii::$app->name ?></p>
            <p class='hero-text'><?= Yii::t('app', 'Do you want to start getting your life together? Start right here, right now!') ?></p>
        </div>
        <!-- From Uiverse.io by Creatlydev --> 
        <a href="<?= Url::toRoute(['user/signup']) ?>" class='cta-btn'>
            <span class='button__icon-wrapper'>
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
        </a>
         <a class="scroll-btn" href="#content">
            <svg xmlns="http://www.w3.org/2000/svg"  width="60"  height="60"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-compact-down down-arrow"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 11l8 3l8 -3" /></svg>
        </a>

        <?= Html::img(
            Yii::getAlias('@web/images/EfficientHero.png'),
            [
                'alt' => 'Hero Background',
            ],
        ) ?>
        <?= Html::img(
            Yii::getAlias('@web/images/EfficientHeroPhone.png'),
            [
                'class' => 'hero-img-phone',
                'alt' => 'Hero Background',
            ],
            ) ?>
    </div>
    
    <span id="content"></span>
    <br>
    <br>
    <br>
    <br>

    <div class="index-section index-double-section" id="features">
        <div class="section-side">
            <!-- <p class="features-eyebrow"><?= Yii::t('app', 'Everything in one place') ?></p> -->
            <h3><?= Yii::t('app', 'Organize life, achieve goals, track progress') ?>, <span style="color: var(--primary-color)"><?= Yii::t('app', 'live fully') ?></span>.</h3>
            <p class="features-sub"><?= Yii::t('app', 'LifeTrack brings together everything you need to run your day, your finances, and your long-term goals — without switching between five different apps.') ?></p>

            <div class="features-grid">

                <div class="feature-card">
                    <div class="feature-card-header">
                        <div class="feature-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                        </div>
                        <p class="feature-card-title"><?= Yii::t('app', 'Finance') ?></p>
                    </div>
                    <p class="feature-card-desc"><?= Yii::t('app', 'Track accounts, income, expenses and transfers across currencies.') ?></p>
                </div>

                <div class="feature-card">
                    <div class="feature-card-header">
                        <div class="feature-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                        </div>
                        <p class="feature-card-title"><?= Yii::t('app', 'Tasks') ?></p>
                    </div>
                    <p class="feature-card-desc"><?= Yii::t('app', 'Categorized to-dos with quick add from anywhere in the app.') ?></p>
                </div>

                <div class="feature-card">
                    <div class="feature-card-header">
                        <div class="feature-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" /><path d="M13 8l2 0" /><path d="M13 12l2 0" /></svg>
                        </div>
                        <p class="feature-card-title"><?= Yii::t('app', 'Notes') ?></p>
                    </div>
                    <p class="feature-card-desc"><?= Yii::t('app', 'Rich text notes with formatting and images. Capture ideas instantly.') ?></p>
                </div>

                <div class="feature-card">
                    <div class="feature-card-header">
                        <div class="feature-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M4 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M14 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /></svg>
                        </div>
                        <p class="feature-card-title"><?= Yii::t('app', 'Your dashboard') ?></p>
                    </div>
                    <p class="feature-card-desc"><?= Yii::t('app', 'Pick your accent color, reorder sections, pin what matters most.') ?></p>
                </div>

            </div>
            <h3 class="features-eyebrow">
                <?= Yii::t('app', 'Everything shown above, on one screen.') ?> 
            </h3>
        </div>
        <div class="section-side laptop-side user-select-none">
            <?= Html::img(
                Yii::getAlias('@web/images/LaptopTransparent.png'),
                [
                    'class' => 'laptop-photo',
                    'alt'   => 'Laptop Dashboard',
                    ],
            ) ?>
        </div>
    </div>

    <div class="index-section how-it-works-section" id="how-it-works">
        <div class="scroll-indicator left">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="scroll-indicator right">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="hiw-inner">

            <p class="hiw-eyebrow"><?= Yii::t('app', 'Simple by design') ?></p>
            <h3 class="hiw-title"><?= Yii::t('app', 'How it works') ?></h3>

            <div class="hiw-steps">

                <div class="hiw-line"></div>

                <div class="hiw-step">
                    <div class="hiw-circle">
                        <div class="hiw-circle-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            <span class="hiw-step-num">1</span>
                        </div>
                    </div>
                    <p class="hiw-step-title"><?= Yii::t('app', 'Create your account') ?></p>
                    <p class="hiw-step-desc"><?= Yii::t('app', 'Sign up in seconds. No credit card, no commitments.') ?></p>
                </div>

                <div class="hiw-step">
                    <div class="hiw-circle">
                        <div class="hiw-circle-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M4 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /><path d="M14 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" /></svg>
                            <span class="hiw-step-num">2</span>
                        </div>
                    </div>
                    <p class="hiw-step-title"><?= Yii::t('app', 'Set up your dashboard') ?></p>
                    <p class="hiw-step-desc"><?= Yii::t('app', 'Pick your accent color, add your accounts, and arrange sections your way.') ?></p>
                </div>

                <div class="hiw-step">
                    <div class="hiw-circle">
                        <div class="hiw-circle-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                            <span class="hiw-step-num">3</span>
                        </div>
                    </div>
                    <p class="hiw-step-title"><?= Yii::t('app', 'Start tracking') ?></p>
                    <p class="hiw-step-desc"><?= Yii::t('app', 'Log expenses, check off tasks, write notes — everything in one place, every day.') ?></p>
                </div>

            </div>

        </div>
    </div>

    <section class="comparison-section">
        <!-- <p class="comparison-eyebrow">Why LifeTrack</p> -->
        <h2 class="comparison-title"><span style="color: var(--primary-color)">Why LifeTrack?</span> Everything in one place.</h2>
        <p class="comparison-subtitle">Most apps only solve one problem. LifeTrack solves all of them -- for free.</p>

        <div class="comparison-table-wrap">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th></th>
                        <th class="col-lifetrack">
                            LifeTrack
                            <div class="comparison-badge">free</div>
                        </th>
                        <th>Notion</th>
                        <th>Money Manager</th>
                        <th>Google Tasks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row-label">Finance tracking</div>
                            <div class="row-sub">accounts, income, expenses</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-cross">✕</span></td>
                        <td><span class="cell-check">✓</span></td>
                        <td><span class="cell-cross">✕</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">Multi-currency</div>
                            <div class="row-sub">live exchange rates</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-cross">✕</span></td>
                        <td><span class="cell-partial">Paid only</span></td>
                        <td><span class="cell-cross">✕</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">Notes</div>
                            <div class="row-sub">rich text, formatting</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-check">✓</span></td>
                        <td><span class="cell-cross">✕</span></td>
                        <td><span class="cell-cross">✕</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">Task management</div>
                            <div class="row-sub">to-dos, reminders</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-check">✓</span></td>
                        <td><span class="cell-cross">✕</span></td>
                        <td><span class="cell-check">✓</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">Completely free</div>
                            <div class="row-sub">no credit card required</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-partial">Limited free</span></td>
                        <td><span class="cell-partial">Freemium</span></td>
                        <td><span class="cell-check">✓</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">PWA / installable</div>
                            <div class="row-sub">works like a native app</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-check">✓</span></td>
                        <td><span class="cell-check">✓</span></td>
                        <td><span class="cell-check">✓</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="row-label">All-in-one</div>
                            <div class="row-sub">no app switching needed</div>
                        </td>
                        <td class="col-lifetrack"><span class="cell-check">✓</span></td>
                        <td><span class="cell-partial">Mostly</span></td>
                        <td><span class="cell-cross">✕</span></td>
                        <td><span class="cell-cross">✕</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>



</div>
