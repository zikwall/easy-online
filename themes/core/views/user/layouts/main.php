<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;

\zikwall\easyonline\themes\core\bundles\EncoreBundle::register($this);

?>
<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= strip_tags($this->pageTitle); ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head() ?>
    </head>
    <body class="login_page">
    <?php $this->beginBody() ?>

    <?= \zikwall\easyonline\modules\ui\widgets\HeaderMenu::widget(); ?>

    <div id="main-container" class="container page_layout">
        <div class="page-body" style="margin-bottom: 40px;">
            <div class="col-md-12 col-no-right-padding">
                    <?= $content; ?>
                    <div id="footer-wrap" class="footer-wrap float_right">
                        <div class="footer-nav">
                            <div class="footer-column column-offset-1">
                                <a href="/about">ВСистеме</a> © 2019
                            </div>
                            <div class="footer-column column-offset-2">
                                Язык:
                                <a class="f-nav footer-lang-link hover-underline cursor_pointer">English</a>
                                <a class="f-nav footer-lang-link hover-underline cursor_pointer">Русский</a>
                                <a class="f-nav footer-lang-link hover-underline cursor_pointer">Українська</a>
                                <a class="f-nav footer-lang-link hover-underline cursor_pointer"
                                   href="<?= Url::to(['/user/auth/languages']) ?>"
                                   data-action-click="ui.modal.load"
                                   data-action-url="<?= Url::to(['/user/auth/languages']) ?>">
                                    все языки »
                                </a>
                            </div>
                            <div class="footer-column column-offset-2">
                                <a class="f-nav" href="/about">о компании</a>
                                <a class="f-nav" href="/support?act=home" style="display: none;">помощь</a>
                                <a class="f-nav" href="/terms">правила</a>
                                <a class="f-nav" href="/ads" style="">реклама</a>

                                <a class="f-nav" href="/dev">разработчикам</a>
                                <a class="f-nav" href="/jobs" style="display: none;">вакансии</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
