<?php $this->beginContent('@easyonline/modules/admin/views/layouts/main.php') ?>
<div class="page_block">
    <?= \zikwall\easyonline\modules\schedule\widgets\ScheduleAdminTabs::widget(); ?>

    <?= $content; ?>
</div>
<?php $this->endContent(); ?>
