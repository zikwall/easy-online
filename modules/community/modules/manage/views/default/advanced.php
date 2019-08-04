<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;
?>


<div class="panel panel-default">

    <div>
        <div class="panel-heading">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Community</strong> settings'); ?>
        </div>
    </div>

    <?= DefaultMenu::widget(['community' => $model]); ?>
    <div class="panel-body">

        <?php $form = ActiveForm::begin(['options' => ['id' => 'communityIndexForm'], 'enableClientValidation' => false]); ?>

        <?php if (Yii::$app->urlManager->enablePrettyUrl): ?>
            <?= $form->field($model, 'url')->hint(Yii::t('CommunityModule.manage', 'e.g. example for {baseUrl}/s/example', ['baseUrl' => Url::base(true)])); ?>
        <?php endif; ?>
        <?= $form->field($model, 'indexUrl')->dropDownList($indexModuleSelection)->hint(Yii::t('CommunityModule.manage', 'the default start page of this community for members')) ?>
        <?= $form->field($model, 'indexGuestUrl')->dropDownList($indexModuleSelection)->hint(Yii::t('CommunityModule.manage', 'the default start page of this community for visitors')) ?>

        <?= Html::submitButton(Yii::t('CommunityModule.views_admin_edit', 'Save'), array('class' => 'btn btn-primary', 'data-ui-loader' => '')); ?>

        <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>

        <div class="pull-right">
            <?php if ($model->status == Community::STATUS_ENABLED || $model->status == Community::STATUS_ARCHIVED) : ?>
                <a href="#"  <?= $model->status == Community::STATUS_ARCHIVED ? 'style="display:none;"' : '' ?> class="btn btn-warning archive"
                   data-action-click="community.archive"  data-action-url="<?= $model->createUrl('/community/manage/default/archive') ?>" data-ui-loader>
                    <?= Yii::t('CommunityModule.views_admin_edit', 'Archive') ?>
                </a>
                <a href="#" <?= $model->status == Community::STATUS_ENABLED ? 'style="display:none;"' : '' ?> class="btn btn-warning unarchive"
                   data-action-click="community.unarchive" data-action-url="<?= $model->createUrl('/community/manage/default/unarchive') ?>"  data-ui-loader>
                    <?= Yii::t('CommunityModule.views_admin_edit', 'Unarchive') ?>
                </a>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


