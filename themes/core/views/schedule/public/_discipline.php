<?php

use zikwall\easyonline\modules\core\libs\Html;
use zikwall\easyonline\modules\schedule\components\cellconstructor\helpers\Helper;
use zikwall\easyonline\modules\schedule\models\ScheduleHelper;

/**
 * @var \zikwall\easyonline\modules\schedule\models\ScheduleSchedule $dailyDiscipline
 */

$style = 'box-shadow: 0 0 10px '.Yii::$app->getModule('schedule')->settings->get('activeDisciplineColor');

?>

<div id="#daily-<?= $dailyDiscipline->id ?>" class="page_block active_block_left">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <div class="discipline-name-header" style="max-width: 80%; overflow-x: auto; z-index: 10000;">
                <span rel="popover" data-placement="bottom"
                      data-content="<?= $dailyDiscipline->weeklyType->name; ?>">
                (<?= $dailyDiscipline->weeklyType->sign; ?>)
            </span> <?= $dailyDiscipline->discipline->name; ?>
                (<span rel="popover" data-placement="bottom"
                       data-content="<?= $dailyDiscipline->type->name; ?>">
                <?= $dailyDiscipline->type->sign; ?>
            </span>)
            </div>
        </div>
    </div>

    <?= $this->render('_disciplineActions', [
        'discipline' => $dailyDiscipline,
        'day' => $dailyDiscipline->day_id,
        'couple' => $dailyDiscipline->couple_id,
        'group' => $dailyDiscipline->study_group_id
    ]); ?>
    <br>
    <div class="page_info_wrap">
        <div class="search_filter_main">
            Местоположение:
            <?= Html::a('<i class="fa fa-map-marker fa-lg" style="color: #e85d09;"></i> '.$dailyDiscipline->classroom->getFullDisplyaRoom(), [
                '/faculties/classroom-public/view-ajax',
                'classroom' =>  $dailyDiscipline->classroom->id], [
                'class' => 'popoverTrigger',
                'data-target' => '#globalModal',
                'data-toggle' => 'modal',
                'rel' => 'popover',
                'data-placement' => 'bottom',
                'data-trigger' => 'hover',
                'data-content' => $dailyDiscipline->classroom->classroomType->name
            ]); ?>
        </div>

        <div class="separator"></div>

        <div class="search_filter_main">
            Преподаватель:
            (<?= Html::tag('span', $dailyDiscipline->teacher->science->shortname, [
                'class' => '',
                'rel' => 'popover',
                'data-placement' => 'bottom',
                'data-trigger' => 'hover',
                'data-toggle'=>'modal',
                'data-content' => $dailyDiscipline->teacher->science->name
            ]); ?>)
            <?= Html::a($dailyDiscipline->teacher->user->getDisplayName(), ['/schedule/public/teacher-ajax', 'id' => $dailyDiscipline->teacher->id],[
                'data-target' => '#globalModal',
            ]); ?>
        </div>

        <?php if ($dailyDiscipline->scheduleLinkSubgroups): ?>
            <div class="separator"></div>

            <div class="panel panel-warning">
                <div class="panel-body">
                    <?php
                    $subGroup = $dailyDiscipline->getSubgroups()->one();
                    echo $subGroup->name;
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->hasModule('issues')): ?>
            <?php if ($dailyDiscipline->scheduleLinkIssues): ?>

                <div class="separator"></div>

                <div class="panel-body">
                    <p class="panel-heading">
                        Задачи:
                        <a class="dropdown-toggle"
                           onclick="$('#viewIssues<?= $dailyDiscipline->id;?>').slideToggle('fast');$('#viewIssues<?= $dailyDiscipline->id;?>').focus();return false;"
                           data-toggle="dropdown" href="#"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-angle-down fa-fw"></i>
                        </a>
                    </p>
                    <div id="viewIssues<?= $dailyDiscipline->id;?>" style="display: none;">
                        <ul class="tour-list">
                            <?php foreach ($dailyDiscipline->scheduleLinkIssues as $issue): ?>
                                <li id="interface_entry" class="">
                                    <?= Html::a('<i class="fa fa-chevron-right"></i> '.$issue->issues->title, $issue->issues->content->getUrl(), ['class' => '']); ?>
                                </li><hr>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    //$('.popoverTrigger').popover({ trigger: "hover" });
</script>
