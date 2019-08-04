<?php
\zikwall\easyonline\modules\core\assets\subassets\TabbedFormAsset::register($this);

zikwall\easyonline\modules\user\widgets\AccountMenu::markAsActive(['/user/account/edit-settings']);
?>

<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UserModule.account', '<strong>User</strong> settings'); ?>
            <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>
        </div>
    </div>

    <?= \zikwall\easyonline\modules\user\widgets\AccountSettingsMenu::widget(); ?>

    <div class="page_info_wrap">
        <?= $content; ?>
    </div>
</div>





