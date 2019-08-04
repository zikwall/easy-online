
<div class="row">
    <div class="col-md-9">
        <div class="page_block">
            <div class="page_block_header clear_fix">
                <div class="page_block_header_inner _header_inner">
                    <strong>Пользовательские</strong> настройки универстета
                </div>
            </div>

            <?= \zikwall\easyonline\modules\university\widgets\StudentSetingTabs::widget(); ?>

            <?= $content; ?>

        </div>
    </div>
    <div class="col-md-3 col-no-right-padding">
        <?= \zikwall\easyonline\modules\user\widgets\AccountMenu::widget(); ?>
    </div>
</div>


