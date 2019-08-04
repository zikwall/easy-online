<?php

use yii\helpers\Html;
use zikwall\easyonline\compat\CActiveForm;
use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;
?>


<div class="panel panel-default">
    <div class="panel-heading">
       <?= Yii::t('CommunityModule.views_settings', '<strong>Community</strong> settings'); ?>
    </div>
    <?= DefaultMenu::widget(['community' => $community]); ?>

    <div class="panel-body">
        <p><?= Yii::t('CommunityModule.views_admin_delete', 'Are you sure, that you want to delete this community? All published content will be removed!'); ?></p>
        <p><?= Yii::t('CommunityModule.views_admin_delete', 'Please provide your password to continue!'); ?></p><br>

        <?php $form = CActiveForm::begin(); ?>

        <div class="form-group">
            <?= $form->labelEx($model, 'currentPassword'); ?>
            <?= $form->passwordField($model, 'currentPassword', array('class' => 'form-control', 'rows' => '6')); ?>
            <?= $form->error($model, 'currentPassword'); ?>
        </div>

        <hr>
        <?= Html::submitButton(Yii::t('CommunityModule.views_admin_delete', 'Delete'), array('class' => 'btn btn-danger', 'data-ui-loader' => '')); ?>

        <?php CActiveForm::end(); ?>
    </div>
</div>




