<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;&nbsp;' .
                Yii::t('base', 'Back to overview'),
                Url::to(['index']), ['class' => 'flat_button button_wide secondary', 'data-ui-loader' => '']); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?php if (!$type->isNewRecord) : ?>
           <?= Yii::t('CommunityModule.spacetype', '<strong>Edit</strong> space type'); ?>
        <?php else: ?>
           <?= Yii::t('CommunityModule.spacetype', '<strong>Create</strong> new space type'); ?>
        <?php endif; ?>
    </div>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
]); ?>

<div class="page_info_wrap">
    <?= $form->field($type, 'title')->hint(Yii::t('CommunityModule.spacetype', 'e.g. Projects')) ?>
    <?= $form->field($type, 'item_title')->hint(Yii::t('CommunityModule.spacetype', 'e.g. Project')) ?>
    <?= $form->field($type, 'sort_key') ?>
    <?= $form->field($type, 'show_in_directory')->checkbox() ?>
</div>

<div class="block_footer">
    <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>

    <?php if ($canDelete): ?>
        <?= Html::a(Yii::t('base', 'Delete'), Url::toRoute(['delete', 'id' => $type->id]), array('class' => 'btn btn-danger')); ?>
    <?php endif; ?>
</div>

<?php ActiveForm::end() ?>
