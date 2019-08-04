<?php
$this->registerJsFile('https://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru');
?>
<style>
    .schedule-table {
        border-collapse: collapse;
        width: 100%;
    }
    .schedule-table-schedule {
        border-right: 1px solid #e7e8ec;
        padding: 15px 20px 20px;
        vertical-align: top;
    }
    .schedule-table-groups {
        padding: 0 0 25px;
        width: 250px;
        overflow: hidden;
        vertical-align: top;
    }
</style>

<?= \zikwall\easyonline\modules\ui\widgets\HorizontalSidebar::widget(); ?>
<br><br>

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
    <div>
        <table id="shedule-table" class="schedule-table">
            <tbody>
            <tr>
                <td class="schedule-table-schedule schedule-table-schedule_has_content">
                    <?= $content; ?>
                </td>
                <td id="schedule-study-group-list" class="schedule-table-groups">
                    <?= \zikwall\easyonline\modules\schedule\widgets\ScheduleListGroupsWidget::widget([
                        'faculty' => Yii::$app->request->getQueryParam('faculty'),
                        'course' => Yii::$app->request->getQueryParam('course'),
                    ]); ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?= \zikwall\easyonline\modules\schedule\widgets\byWidget::widget(); ?>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        let sidebar = new StickySidebar('#schedule-study-group-list', {
            containerSelector: '#shedule-table',
            innerWrapperSelector: '.sidebar',
            topSpacing: 55,
            bottomSpacing: 50
        });
    });
</script>



