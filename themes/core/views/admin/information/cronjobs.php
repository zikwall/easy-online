<?php
use zikwall\easyonline\modules\core\widgets\TimeAgo;
?>
<div class="encore-help-block">
    <strong>Status:</strong>
    <?php
    if ($lastRunHourly == "") {
        $lastRunHourly = "<span style='color:red'>" . Yii::t('AdminModule.views_setting_cronjob', 'Never') . "</span>";
    } else {
        $lastRunHourly = TimeAgo::widget(['timestamp' => $lastRunHourly]);
    }
    if ($lastRunDaily == "") {
        $lastRunDaily = "<span style='color:red'>" . Yii::t('AdminModule.views_setting_cronjob', 'Never') . "</span>";
    } else {
        $lastRunDaily = TimeAgo::widget(['timestamp' => $lastRunDaily]);
    }
    ?>
    <br>
    <?= Yii::t('AdminModule.views_setting_cronjob', 'Last run (hourly):'); ?> <?= $lastRunHourly; ?> <br/>
    <?= Yii::t('AdminModule.views_setting_cronjob', 'Last run (daily):'); ?> <?= $lastRunDaily; ?>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_setting_cronjob', 'Please make sure following cronjobs are installed:'); ?>
</div>

<div class="page_info_wrap">
    <div class="dev-block">
        <div class="page_block_header clear_fix">
            <div class="page_block_header_inner _header_inner">
                <?= Yii::t('AdminModule.views_setting_cronjob', 'Crontab of user: {user}', ['{user}' => $currentUser]); ?>
            </div>
        </div>
        <blockquote>
            <pre>30 * * * * <?= Yii::getAlias('@app/yii'); ?> cron/hourly >/dev/null 2>&1</pre>
            <pre>00 18 * * * <?= Yii::getAlias('@app/yii'); ?> cron/daily >/dev/null 2>&1</pre>
        </blockquote>

        <?php if ($currentUser != ""): ?>
            <div class="page_block_header clear_fix">
                <div class="page_block_header_inner _header_inner">
                    <?= Yii::t('AdminModule.views_setting_cronjob', 'Or Crontab of root user'); ?>
                </div>
            </div>
            <blockquote>
                <pre>*/5 * * * * su -c "<?= Yii::getAlias('@app/yii'); ?>  cron/hourly" <?= $currentUser; ?> >/dev/null 2>&1</pre>
                <pre>0 18 * * * su -c "<?= Yii::getAlias('@app/yii'); ?>  cron/daily" <?= $currentUser; ?> >/dev/null 2>&1</pre>
            </blockquote>
        <?php endif; ?>
    </div>
</div>
