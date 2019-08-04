<?php
use zikwall\easyonline\modules\core\libs\Html;
?>
<style>
    .maxi {
        width: 10px;
    }
</style>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <strong>Расписание</strong> занятий
        </div>
    </div>
    <?= \zikwall\easyonline\modules\schedule\widgets\ScheduleCoursesWidget::widget(
        [
            'faculty' => Yii::$app->request->getQueryParam('faculty'),
        ]
    ); ?>
    <div class="page_info_wrap">
        <?= $content; ?>
    </div>
    <?= \zikwall\easyonline\modules\schedule\widgets\byWidget::widget(); ?>
</div>
