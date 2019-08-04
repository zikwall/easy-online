<?php
\zikwall\easyonline\modules\core\assets\subassets\TabbedFormAsset::register($this);

zikwall\easyonline\modules\user\widgets\AccountMenu::markAsActive(['/user/account/edit-settings']);
?>

<div class="panel-heading">
    <?= Yii::t('UserModule.account', '<strong>User</strong> settings'); ?> <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>
</div>

<?= \zikwall\easyonline\modules\user\widgets\AccountSettingsMenu::widget(); ?>

<div class="panel-body">
    <?= $content; ?>
</div>





