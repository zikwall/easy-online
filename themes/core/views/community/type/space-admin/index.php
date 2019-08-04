<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;
?>


<br/>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('CommunityModule.spacetype', '<strong>Change</strong> type'); ?></div>
    <?= DefaultMenu::widget(['community' => $community]); ?>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'community_type_id')->dropdownList($communityTypes); ?>

        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        <?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>

        <?php ActiveForm::end(); ?>
    </div>

</div>


