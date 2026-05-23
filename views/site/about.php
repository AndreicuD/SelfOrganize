<?php
/** @var yii\web\View $this */
use yii\helpers\Html;

$this->title = Yii::t('app', 'About');
?>

<div class="about-page">

    <!-- HERO -->
    <div class="about-section" style="padding-top: 1rem;">
        <span class="badge-pill"><?= Yii::t('app', 'Product') ?></span>
        <h2 class="about-section-title" style="font-size: 1.5rem;"><?= Yii::t('app', 'One place for everything that matters') ?></h2>
        <p class="about-section-sub" style="max-width: 520px; margin-top: 0.5rem;">
            <?= Yii::t('app', 'Self Organize is a personal life-management platform built to help you track your finances, habits, tasks, and projects — without switching between five different apps to do it.') ?>
        </p>
    </div>

    <!-- FEATURES -->
    <div class="about-section">
        <h2 class="about-section-title"><?= Yii::t('app', 'What you can do') ?></h2>
        <p class="about-section-sub"><?= Yii::t('app', 'Everything is designed to be fast to use — whether you\'re at your desk or at a grocery store.') ?></p>
        <div class="about-feature-grid">
            <div class="about-feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" /><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                <p class="about-feature-title"><?= Yii::t('app', 'Finance tracking') ?></p>
                <p class="about-feature-desc"><?= Yii::t('app', 'Multiple accounts, income, expenses, transfers, balance history and charts.') ?></p>
            </div>
            <div class="about-feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
                <p class="about-feature-title"><?= Yii::t('app', 'Tasks & to-dos') ?></p>
                <p class="about-feature-desc"><?= Yii::t('app', 'Categorized tasks, quick add from anywhere, daily overview on your dashboard.') ?></p>
            </div>
            <div class="about-feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                <p class="about-feature-title"><?= Yii::t('app', 'Habits') ?></p>
                <p class="about-feature-desc"><?= Yii::t('app', 'Daily streaks, check-ins, and progress tracking to build routines that stick.') ?></p>
            </div>
            <div class="about-feature-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accent-color"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415" /></svg>
                <p class="about-feature-title"><?= Yii::t('app', 'Projects') ?></p>
                <p class="about-feature-desc"><?= Yii::t('app', 'Goals, resources, and separated to-dos per project. Pin favourites to your dashboard.') ?></p>
            </div>
        </div>
    </div>

    <!-- PWA -->
    <div class="about-section">
        <h2 class="about-section-title"><?= Yii::t('app', 'Built for the phone in your pocket') ?></h2>
        <p class="about-section-sub">
            <?= Yii::t('app', 'Self Organize is a progressive web app — install it on your home screen and it works like a native app. No app store required. The interface is designed to be fast and comfortable to use one-handed, so logging an expense or checking off a task takes seconds, not minutes.') ?>
        </p>
        <div class="about-stat-grid">
            <div class="about-stat-card">
                <p class="about-stat-label"><?= Yii::t('app', 'Works offline') ?></p>
                <p class="about-stat-value"><?= Yii::t('app', 'PWA ready') ?></p>
            </div>
            <div class="about-stat-card">
                <p class="about-stat-label"><?= Yii::t('app', 'Add to homescreen') ?></p>
                <p class="about-stat-value"><?= Yii::t('app', 'No app store') ?></p>
            </div>
            <div class="about-stat-card">
                <p class="about-stat-label"><?= Yii::t('app', 'Light & dark mode') ?></p>
                <p class="about-stat-value"><?= Yii::t('app', 'Your preference') ?></p>
            </div>
            <div class="about-stat-card">
                <p class="about-stat-label"><?= Yii::t('app', 'Accent color') ?></p>
                <p class="about-stat-value"><?= Yii::t('app', 'Make it yours') ?></p>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="about-section">
        <h2 class="about-section-title"><?= Yii::t('app', 'Frequently asked questions') ?></h2>
        <div class="about-faq">
            <div class="about-faq-item">
                <p class="about-faq-q"><?= Yii::t('app', 'Is Self Organize free to use?') ?></p>
                <p class="about-faq-a"><?= Yii::t('app', 'Yes — Self Organize is currently free for all users. Future plans may introduce optional premium features, but the core functionality will always remain accessible.') ?></p>
            </div>
            <div class="about-faq-item">
                <p class="about-faq-q"><?= Yii::t('app', 'Is my data private and secure?') ?></p>
                <p class="about-faq-a"><?= Yii::t('app', 'Your data is stored securely and is never shared with third parties. Each account is isolated — only you can see your finances, tasks, and habits.') ?></p>
            </div>
            <div class="about-faq-item">
                <p class="about-faq-q"><?= Yii::t('app', 'Can I use it on my phone without installing anything?') ?></p>
                <p class="about-faq-a"><?= Yii::t('app', 'Yes. Open Self Organize in your mobile browser and tap "Add to home screen." It will work like a native app — no app store, no downloads.') ?></p>
            </div>
            <div class="about-faq-item">
                <p class="about-faq-q"><?= Yii::t('app', 'What currencies are supported?') ?></p>
                <p class="about-faq-a"><?= Yii::t('app', 'Self Organize supports RON, EUR, USD, GBP, CHF, JPY, CAD, AUD and more. You can hold accounts in different currencies and set a preferred currency for your totals — conversion is handled automatically.') ?></p>
            </div>
            <div class="about-faq-item">
                <p class="about-faq-q"><?= Yii::t('app', 'Can I delete my account and data?') ?></p>
                <p class="about-faq-a"><?= Yii::t('app', 'Yes. You can request full account and data deletion at any time by contacting us at the email below.') ?></p>
            </div>
        </div>
    </div>

    <!-- CONTACT -->
    <div class="about-section">
        <h2 class="about-section-title"><?= Yii::t('app', 'Get in touch') ?></h2>
        <p class="about-section-sub"><?= Yii::t('app', 'Have a question, found a bug, or want to share feedback? We\'d love to hear from you.') ?></p>
        <div class="about-contact-grid">
            <div class="about-contact-card">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accent-color" style="flex-shrink: 0;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                <div>
                    <p class="about-stat-label"><?= Yii::t('app', 'Email') ?></p>
                    <p class="about-stat-value"><?= Html::a('contact@selforganize.app', 'mailto:contact@selforganize.app', ['class' => 'accent-color']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- STORY -->
    <div class="about-section">
        <h2 class="about-section-title"><?= Yii::t('app', 'The story') ?></h2>
        <p class="about-section-sub">
            <?= Yii::t('app', 'Self Organize started as a personal project by Andrei Huțanu, a developer and student at Colegiul Național de Informatică "Tudor Vianu" in Bucharest. The idea was simple — there was no single app that combined finances, tasks, habits, and projects in a way that felt fast and personal enough to actually use every day.') ?>
        </p>
        <p class="about-section-sub" style="margin-top: 1rem;">
            <?= Yii::t('app', 'Beyond code, Andrei is a musician — member of indie rock band Patron and part of the Darkened Tunes music project. That creative background shows in the app\'s attention to feel, atmosphere, and the small details that make something enjoyable to use daily.') ?>
        </p>
    </div>

</div>