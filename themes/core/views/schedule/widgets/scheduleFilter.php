<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\range\RangeInput;

?>
<br>
<?php $form = ActiveForm::begin(); ?>
<div class="page_block" id="<?= $id; ?>" style="display: none">
    <div class="page_info_wrap">
        <div class="row">
            <div class="col-md-3">
                <p class="panel-heading">Дни недели</p><hr>

                <?= Html::checkboxList('days', $days, \zikwall\easyonline\modules\schedule\models\ScheduleAviableDay::getList(), [
                    'separator' => '<br>'
                ]) ?>
            </div>
            <div class="col-md-3">
                <p class="panel-heading">Пары</p><hr>
                <?= Html::checkboxList('couples', $couples, \zikwall\easyonline\modules\schedule\models\ScheduleAviableCouple::getList(), [
                    'separator' => '<br>'
                ]) ?>
            </div>
            <div class="col-md-6">
                <p class="panel-heading">Опциональные фильры:</p><hr>
                <label>Типы учебных недель</label>
                <?= Html::radioList('weekly', $weekly, \zikwall\easyonline\modules\schedule\models\ScheduleWeeklyType::getList(), [
                    'class' => 'form-control',
                    'itemOptions' => ['class' => 'radio'],
                ]); ?>
                <?php if (!$isContainer && empty($group)): ?>
                    <br><label>По предметам</label>
                    <?= Html::dropDownList('disciplines', $disciplines, \zikwall\easyonline\modules\university\models\UniversityDiscipline::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <br><label>По преподавателям</label>
                    <?= Html::dropDownList('teachers', $teachers, \zikwall\easyonline\modules\university\models\UniversityTeachers::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'teacher-id',
                        'data-ui-select2' => ''
                    ]); ?>
                <?php else: ?>
                    <br><label>По предметам</label>
                    <?= Html::dropDownList('disciplines', $disciplines, \zikwall\easyonline\modules\university\models\UniversityDiscipline::getListLikeGroup($group),[
                        'multiple' => true,
                        'id' => 'discipline-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <br><label>По преподавателям</label>
                    <?= Html::dropDownList('teachers', $teachers, \zikwall\easyonline\modules\university\models\UniversityTeachers::getListLikeGroup($group) ,[
                        'multiple' => true,
                        'id' => 'teacher-id',
                        'data-ui-select2' => ''
                    ]); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <p class="panel-heading">Типы предметов</p>
                <?= Html::checkboxList('types', $types, \zikwall\easyonline\modules\schedule\models\ScheduleLessonType::getList(), [
                    'class' => 'form-control',
                    'separator' => ' | '
                ]); ?>
            </div>
            <?php if (!$isContainer && empty($group)): ?>
                <div class="col-md-6">
                    <hr>
                    <p class="panel-heading">По учебным группам (которые есть в расписании)</p>
                    <?= Html::dropDownList('groups', $groups, \zikwall\easyonline\modules\university\models\UniversityStudyGroups::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'group-id',
                        'data-ui-select2' => ''
                    ]); ?>
                    <hr>
                    <p class="panel-heading">По всем учебным группам</p>
                    <?= Html::dropDownList('groupsAll', $groupsAll, \zikwall\easyonline\modules\university\models\UniversityStudyGroups::getListAllLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'group-all-id',
                        'data-ui-select2' => ''
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <hr>
                    <p class="panel-heading">По аудиториям</p>
                    <?= Html::dropDownList('classrooms', $classrooms, \zikwall\easyonline\modules\faculties\models\UniversityBuildingClassroom::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'classroom-id',
                        'data-ui-select2' => ''
                    ]); ?>

                    <hr>
                    <p class="panel-heading">По профилям обучения</p>
                    <?= Html::dropDownList('profiles', $profiles, \zikwall\easyonline\modules\specialities\models\UniversitySpecialitiesProfiles::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'profile-id',
                        'data-ui-select2' => ''
                    ]); ?>

                    <hr>
                    <p class="panel-heading">По специальностям обучения</p>
                    <?= Html::dropDownList('specialities', $specialities, \zikwall\easyonline\modules\specialities\models\UniversitySpecialities::getListLikeFacultyAndCourse($faculty, $course) ,[
                        'multiple' => true,
                        'id' => 'speciality-id',
                        'data-ui-select2' => ''
                    ]); ?>
                </div>
            <?php endif; ?>
        </div>
        <hr>
        <p class="panel-heading">Количество отображаемых групп</p>
        <?= RangeInput::widget([
            'name' => 'pageSize',
            'value' => $pageSize,
            'html5Options' => ['min' => 1, 'max' => 6],
        ]);?>
    </div>
    <div class="shedule_block_footer ">
        <div>
            <div class="form-group">
                <?= Html::submitButton('Найти интересующие меня занятия!', [
                    'class' => 'flat_button secondary ui_load_more_btn _ui_load_more_btn _ui_groups_load_more',
                    'data-method' => 'post', 'style' => 'width: 100%;'
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
