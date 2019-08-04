<?php

use zikwall\easyonline\modules\community\models\Community;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use zikwall\easyonline\modules\community\modules\manage\widgets\SecurityTabMenu;
use zikwall\easyonline\modules\core\widgets\DataSaved;


/* @var $model Community */
?>
<div class="page_block">
    <?= SecurityTabMenu::widget(['community' => $model]); ?>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Security</strong> settings'); ?>
        </div>
    </div>

    <div class="page_info_wrap">
        <?php $form = ActiveForm::begin(); ?>

        <?php
        $visibilities = [
            Community::VISIBILITY_NONE => Yii::t('CommunityModule.base', 'Private (Invisible)'),
            Community::VISIBILITY_REGISTERED_ONLY => Yii::t('CommunityModule.base', 'Public (Registered users only)')
        ];
        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') == 1) {
            $visibilities[Community::VISIBILITY_ALL] = Yii::t('CommunityModule.base', 'Visible for all (members and guests)');
        }
        ?>
        <?= $form->field($model, 'visibility')->dropDownList($visibilities); ?>

        <?php $joinPolicies = [0 => Yii::t('CommunityModule.base', 'Only by invite'), 1 => Yii::t('CommunityModule.base', 'Invite and request'), 2 => Yii::t('CommunityModule.base', 'Everyone can enter')]; ?>
        <?= $form->field($model, 'join_policy')->dropDownList($joinPolicies, ['disabled' => $model->visibility == Community::VISIBILITY_NONE]); ?>


        <?php $defaultVisibilityLabel = Yii::t('CommunityModule.base', 'Default') . ' (' . ((Yii::$app->getModule('community')->settings->get('defaultContentVisibility') == 1) ? Yii::t('CommunityModule.base', 'Public') : Yii::t('CommunityModule.base', 'Private')) . ')'; ?>
        <?php $contentVisibilities = ['' => $defaultVisibilityLabel, 0 => Yii::t('CommunityModule.base', 'Private'), 1 => Yii::t('CommunityModule.base', 'Public')]; ?>
        <?= $form->field($model, 'default_content_visibility')->dropDownList($contentVisibilities, ['disabled' => $model->visibility == Community::VISIBILITY_NONE]); ?>

        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>

        <?= DataSaved::widget(); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script>
    $('#community-visibility').on('change', function() {
        if (this.value == 0) {
            $('#community-join_policy, #community-default_content_visibility').val('0').prop('disabled', true);
        } else {
            $('#community-join_policy, #community-default_content_visibility').val('0').prop('disabled', false);
        }
    });

</script>


