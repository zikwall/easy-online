<?php

use yii\helpers\Html;
use yii\helpers\Url;
use zikwall\easyonline\compat\CActiveForm;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;
?>

<div class="page_block">
    <?= DefaultMenu::widget(['community' => $model]); ?>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Community</strong> settings'); ?>
        </div>
    </div>

    <div class="encore-help-block">
        <p><?= Yii::t('CommunityModule.views_admin_delete', 'Are you sure, that you want to delete this community? All published content will be removed!'); ?></p>
        <p><?= Yii::t('CommunityModule.views_admin_delete', 'Please provide your password to continue!'); ?></p><br>
    </div>

    <div class="page_info_wrap">
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




