<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;
use zikwall\easyonline\modules\community\widgets\CommunityNameColorInput;

?>

<div class="page_block">
    <?= DefaultMenu::widget(['community' => $model]); ?>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Community</strong> settings'); ?>
        </div>
    </div>

    <div class="page_info_wrap">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'communityIndexForm'], 'enableClientValidation' => false]); ?>

        <?= zikwall\easyonline\modules\community\widgets\CommunityNameColorInput::widget(['form' => $form, 'model' => $model])?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]); ?>

        <?= $form->field($model, 'tags')->textInput(['maxlength' => 200]); ?>


        <?= Html::submitButton(Yii::t('CommunityModule.views_admin_edit', 'Save'), array('class' => 'btn btn-primary', 'data-ui-loader' => '')); ?>

        <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>

        <div class="pull-right">
            <?php if ($model->isCommunityOwner()) : ?>
                <?= Html::a(Yii::t('CommunityModule.views_admin_edit', 'Delete'), $model->createUrl('delete'), array('class' => 'btn btn-danger', 'data-post' => 'POST')); ?>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
