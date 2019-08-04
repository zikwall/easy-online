<?php \zikwall\easyonline\modules\core\assets\subassets\TabbedFormAsset::register($this); ?>

<div class="panel-heading">
    <?= Yii::t('UserModule.account', '<strong>Your</strong> profile'); ?> <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>
</div>

<?= zikwall\easyonline\modules\user\widgets\AccountProfileMenu::widget(); ?>

<div class="panel-body">
    <?= $content; ?>
</div>





