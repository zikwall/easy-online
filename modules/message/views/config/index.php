<?php

use zikwall\easyonline\modules\core\widgets\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $model \zikwall\easyonline\modules\message\models\Config */
?>

<div class="panel panel-default">

    <div class="panel-heading"><?= Yii::t('MessageModule.base', '<strong>Mail</strong> module configuration'); ?></div>

    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form']); ?>

            <?= $form->field($model, 'showInTopNav')->checkbox(); ?>

            <hr>
            <?= $form->field($model, 'userConversationRestriction')->textInput(['type' => 'number']); ?>
            <?php // $form->field($model, 'userMessageRestriction')->textInput(['type' => 'number']); ?>

            <hr>
            <?= $form->field($model, 'newUserRestrictionEnabled')->checkbox(['id' => 'newUserCheckbox']); ?>
            <div id="newUserRestriction">
                <?= $form->field($model, 'newUserSinceDays')->textInput(['type' => 'number']); ?>
                <?= $form->field($model, 'newUserConversationRestriction')->textInput(['type' => 'number']); ?>
                <?php // $form->field($model, 'newUserMessageRestriction')->textInput(['type' => 'number']); ?>
            </div>

            <div class="alert alert-info">
                <i class="fa fa-info-circle"></i> <?= Yii::t('MessageModule.base', 'Leave fields blank in order to disable a restriction.') ?>
            </div>

        <?= Button::save()->submit() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    function checkNewUserFields()
    {
        var disabled = !$('#newUserCheckbox').is(':checked');
        if (!$('#newUserCheckbox').is(':checked')) {
            $('#newUserRestriction').hide();
        } else {
            $('#newUserRestriction').show();
        }
    }

    checkNewUserFields();

    $('#newUserCheckbox').on('change', function() {
        checkNewUserFields();
    })
</script>
