<?php $this->beginContent('@admin/views/layouts/main.php') ?>
    <div class="page_block">
        <?= \zikwall\easyonline\modules\user\widgets\UserModuleTabs::widget(); ?>

        <?= $content; ?>
    </div>
<?php $this->endContent(); ?>



