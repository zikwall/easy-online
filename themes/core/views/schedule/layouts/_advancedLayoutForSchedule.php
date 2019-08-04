<?php

use zikwall\easyonline\modules\core\libs\Html;

$getCourse = !empty(Yii::$app->request->getQueryParam('course')) ? Yii::$app->request->getQueryParam('course') : 1;
$checkCourse = !empty($course) ? $course : $getCourse;
?>

<?php \zikwall\easyonline\modules\schedule\widgets\ScheduleAdminTabs::markAsActive(['/schedule/admin/index']); ?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a(Yii::t('ScheduleModule.base', 'Создать расписание для {course} курса', ['course' => $checkCourse]), [
                'create',
                'faculty' => !empty($faculty) ? $faculty : Yii::$app->request->getQueryParam('faculty'),
                'course' => $checkCourse
            ], ['class' => 'btn btn-success']) ?>
            <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'),]); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('UniversityModule.setting', 'Управление расписанием'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('UniversityModule.setting', 'Теперь управление расписанием Вашего университеа будет максимально проста!'); ?>
</div>

<?= \zikwall\easyonline\modules\schedule\widgets\ScheduleAdminCoursesWidget::widget([
    'faculty' => !empty($faculty) ? $faculty : Yii::$app->request->getQueryParam('faculty'),
    'course' => $checkCourse
]); ?>

<div class="page_info_wrap">
    <?= $content; ?>
</div>
