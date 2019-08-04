<div id="topbar-first" class="topbar">
    <div class="container">
        <div class="topbar-brand hidden-xs logo-wrap">
            <a class="logo logo_link" href="/home">EnCore</a>
        </div>

        <a class="top-link" href="/dev/manuals">Документация</a>
        <a class="top-link" href="/dev/apps">Мои приложения</a>
        <a class="top-link" href="/dev/support">Поддержка</a>

        <?= \zikwall\easyonline\modules\user\widgets\AccountTopMenu::widget(); ?>

        <?= \zikwall\easyonline\modules\ui\widgets\Notification::widget(); ?>
    </div>
</div>

