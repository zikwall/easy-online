<?php
use zikwall\easyonline\modules\core\libs\Html;
?>
<?php \zikwall\easyonline\modules\schedule\widgets\ScheduleAdminTabs::markAsActive(['/schedule/admin/index']); ?>

<div class="encore-help-block">
    <?= Yii::t('UniversityModule.setting', 'Расширьте информационный мир Вашего университета с помощью расписания.'); ?>
    <div class="pull-right">
        <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'),]); ?>
    </div>
</div>


<?= \zikwall\easyonline\modules\schedule\widgets\ScheduleAdvancedMenu::widget(); ?>

<?= $content; ?>


