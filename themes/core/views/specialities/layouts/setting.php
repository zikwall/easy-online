<?php $this->beginContent('@admin/views/layouts/main.php') ?>

    <div class="page_block">

        <div class="page_block_header clear_fix">
            <div class="page_block_header_inner _header_inner">
                <?= Yii::t('SpecialitiesModule.base', '<strong>Specialities</strong> and Profiles'); ?>
            </div>
        </div>

        <?= \zikwall\easyonline\modules\specialities\widgets\NavigationMenu::widget(); ?>

        <?= $content; ?>
    </div>

<?php $this->endContent(); ?>
