<?php
\zikwall\easyonline\modules\admin\widgets\AdminSidebarWidget::markAsActive(['/admin/setting']);
?>

<div class="card card-nav-tabs">
    <div class="card-header" data-background-color="purple">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <?= \zikwall\easyonline\modules\admin\widgets\SettingsMenuTabsWidget::widget(); ?>
            </div>
        </div>
    </div>
    <div class="card-content">

        <?= $content; ?>

    </div>
</div>



