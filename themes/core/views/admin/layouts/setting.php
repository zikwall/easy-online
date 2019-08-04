<?php
    \zikwall\easyonline\modules\admin\widgets\AdminSidebarWidget::markAsActive(['/admin/setting']);
?>

<?php $this->beginContent('@admin/views/layouts/main.php') ?>

<div class="page_block">

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('AdminModule.user', '<strong>Settings</strong> and Configuration'); ?>
        </div>
    </div>

    <?= \zikwall\easyonline\modules\admin\widgets\SettingsMenuTabsWidget::widget(); ?>

    <?= $content; ?>
</div>

<?php $this->endContent(); ?>






