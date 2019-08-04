
<?php \zikwall\easyonline\modules\core\assets\subassets\TabbedFormAsset::register($this); ?>

<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UserModule.account', '<strong>Your</strong> profile'); ?> <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>
        </div>
    </div>

    <?= zikwall\easyonline\modules\user\widgets\AccountProfileMenu::widget(); ?>

    <div class="page_info_wrap">
        <?= $content; ?>
    </div>
</div>









