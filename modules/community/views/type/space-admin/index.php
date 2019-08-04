<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use humhub\modules\space\modules\manage\widgets\DefaultMenu;
?>


<br/>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('CommunityModule.spacetype', '<strong>Change</strong> type'); ?></div>
    <?= DefaultMenu::widget(['space' => $space]); ?>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'community_type_id')->dropdownList($spaceTypes); ?>

        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        <?= \humhub\widgets\DataSaved::widget(); ?>

        <?php ActiveForm::end(); ?>
    </div>

</div>


