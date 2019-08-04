<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model zikwall\easyonline\modules\university\models\ScheduleUserLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedule-user-link-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="page_info_wrap">
        <?php if ($model->errors) print_r($model->getErrors()); ?>

        <!--    --><?/*= $form->field($model, 'user_id')->input('number', ['disabled' => true, 'value' => $user, 'readonly' => 'true'])->label(false) */?>
        <?/*= $form->field($model, 'role_id')->textInput() */?>

        <div class="form-group">
            <?= $form->field($model, 'university_id')->dropDownList($model->getUniversityList(), [
                'id' => 'university-id',
                'data-ui-select2' => '',
                'prompt'=>'-Выберите университет-',
                'onchange'=>'
				            $.post( "'.Yii::$app->urlManager->createUrl('/university/user/faculties-list?university=').'"+$(this).val(), function( data ) {
				                $( "select#faculty-id" ).html( data );
				            });'
            ]) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'faculty_id')->dropDownList($model->getFacultyList($model->university_id), [
                'id' => 'faculty-id',
                'data-ui-select2' => '',
                'prompt'=>'-Выберите фаультет-',
                'onchange'=>'
				            $.post( "'.Yii::$app->urlManager->createUrl('/university/user/study-group-list?faculty=').'"+$(this).val(), function( data ) {
				                $( "select#group-id" ).html( data );
				            });'
            ]) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'study_group_id')->dropDownList($model->getStudyGroupList(), ['id' => 'group-id', 'data-ui-select2' => '', 'prompt'=>'-Выберите учебную группу-',]) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'basis_education_id')->dropDownList($model->getBasisEducationList(), ['id' => 'basis-edu-id', 'data-ui-select2' => '']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'form_education_id')->dropDownList($model->getFormEducationList(), ['id' => 'form-edu--id', 'data-ui-select2' => '']) ?>
        </div>
    </div>


    <div class="block_footer">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('UniversityModule.base', 'Create') : Yii::t('UniversityModule.base', 'Update'),
                ['class' => $model->isNewRecord ? 'flat_button button_wide' : 'flat_button secondary button_wide']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

