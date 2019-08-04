
<?php $this->beginContent('@admin/views/layouts/main.php') ?>

<div class="page_block">

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('AdminModule.user', '<strong>Information</strong>'); ?>
        </div>
    </div>

    <?= \zikwall\easyonline\modules\admin\widgets\InformationMenu::widget(); ?>

    <?= $content; ?>
</div>

<?php $this->endContent(); ?>
