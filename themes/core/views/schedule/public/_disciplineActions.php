<?php
/**
 * @var $couple integer
 * @var $group integer
 * @var \zikwall\easyonline\modules\schedule\models\ScheduleSchedule $dailyDiscipline
 */

use yii\bootstrap\Html;

/**
 * @var \zikwall\easyonline\modules\schedule\models\ScheduleSchedule $discipline
 */
?>

<div class="group_row_actions">
    <div class="ui_actions_menu_wrap _ui_menu_wrap groups_actions_menu _actions_menu">
        <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
            <span class="blind_label">Действия</span><div class="groups_actions_icons"></div>
        </div>

        <div class="ui_actions_menu _ui_menu">
            <?= Html::a('Просмотр', [
                '/schedule/public/view-ajax',
                'day' => $day, 'couple' => $couple, 'group' => $group, 'discipline' => $discipline->id
            ], [
                'class' => 'ui_actions_menu_item',
                'data-target' => '#globalModal', 'data-toggle'=>'modal',
            ]) ?>

            <div class="ui_rmenu_sep"></div>

            <?= Html::a('Описание занятия', ['/schedule/public/view-desc-ajax', 'discipline' =>  $discipline->id], [
                'class' => 'ui_actions_menu_item',
                'data-target' => '#globalModal', 'data-toggle'=>'modal',
            ]) ?>

            <?php
            if (Yii::$app->user->can(new \zikwall\easyonline\modules\schedule\permissions\ManageDailySchedule())) {
                echo Html::a('Редактировать', ['/schedule/admin/edit-ajax', 'daily' =>  $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
                    'class' => 'ui_actions_menu_item',
                    'data-target' => '#globalModal', 'data-toggle'=>'modal',
                ]);
            }
            ?>

            <?php
            if (Yii::$app->user->can(new \zikwall\easyonline\modules\schedule\permissions\ManageScheduleIssues())) {
                echo Html::a('Добавить задачи', ['/schedule/admin/add-issues', 'daily' =>  $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
                    'class' => 'ui_actions_menu_item',
                    'data-target' => '#globalModal', 'data-toggle'=>'modal',
                ]);
            }
            ?>

            <?= Html::a('Информация', '', [
                'data-toggle' => 'collapse',
                'data-target' => '#daily' . $discipline->id,
                'class' => 'ui_actions_menu_item'
            ])?>

            <div class="ui_rmenu_sep"></div>

            <?php if (Yii::$app->user->can(new \zikwall\easyonline\modules\schedule\permissions\ManageDailySchedule())): ?>
                    <?= Html::a('Удалить', ['/schedule/admin/delete-ajax', 'id' => $discipline->id, 'faculty' => Yii::$app->request->getQueryParam('faculty'), 'course' => $discipline->studyGroup->course->number], [
                        'class' => 'ui_actions_menu_item',
                        'data' => [
                            'confirm' => 'Вы действительно хотите удалить данное занятие из расписания?',
                            'method' => 'post',
                        ],
                    ]); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
