<?php
\zikwall\easyonline\modules\admin\widgets\AdminMenu::markAsActive(['/admin/space']);
?>

<?php $this->beginContent('@admin/views/layouts/main.php') ?>
<div class="page_block">
    <?= \zikwall\easyonline\modules\community\widgets\CommunityMenu::widget(); ?>

    <?= $content; ?>
</div>
<?php $this->endContent(); ?>
