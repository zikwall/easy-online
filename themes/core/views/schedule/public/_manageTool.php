<?php
use zikwall\easyonline\modules\core\libs\Html;

/**
 * @var \zikwall\easyonline\modules\schedule\models\ScheduleSchedule $discipline
 */

$items = [];

$items[] = Html::a('Информация', [
    '/schedule/admin/day-info',
    'faculty' => Yii::$app->request->getQueryParam('faculty'),
    'course' => $course
], [
    'data-target' => '#globalModal', 'data-toggle'=>'modal',
    'class' => 'ui_actions_menu_item'
]);

$items[] = Html::a('Информация о этой ячейке', [ '/schedule/admin/day-info',
    'faculty' => Yii::$app->request->getQueryParam('faculty'),
    'course' => $course
], [
    'data-target' => '#globalModal', 'data-toggle'=>'modal',
    'class' => 'ui_actions_menu_item'
]);

$items[] = Html::a('Добавить занятие', [ '/schedule/admin/add-ajax',
    'faculty' => Yii::$app->request->getQueryParam('faculty'),
    'course' => $course,
    'day' => $day,
    'couple' => $couple,
    'group' => $group
], [
    'data-target' => '#globalModal', 'data-toggle'=>'modal',
    'class' => 'ui_actions_menu_item'
]);
?>
<div class="page_block">
    <div class="group_row_actions">
        <div class="ui_actions_menu_wrap _ui_menu_wrap groups_actions_menu _actions_menu">
            <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
                <span class="blind_label">Действия</span>
                <div class="groups_actions_icons"></div>
            </div>
            <div class="ui_actions_menu _ui_menu">
                <?= implode(' ', $items); ?>
            </div>
        </div>
    </div>
    <div class="page_info_wrap">
        Режим модератора расписания
    </div>
</div>

