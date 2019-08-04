<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\community\modules\manage\widgets\MemberMenu;
use yii\widgets\ActiveForm;
?>


<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('CommunityModule.views_admin_members', '<strong>Manage</strong> members'); ?>
    </div>
    <?= MemberMenu::widget(['community' => $community]); ?>
    <div class="panel-body">

        <p>
            <?= Yii::t('CommunityModule.manage', 'As owner of this community you can transfer this role to another administrator in community.'); ?>
        </p>

        <?php
        $form = ActiveForm::begin([])
        ?>
        <?= $form->field($model, 'ownerId')->dropDownList($model->getNewOwnerArray()) ?>

        <hr />
        <?= Html::submitButton(Yii::t('CommunityModule.manage', 'Transfer ownership'), ['class' => 'btn btn-danger', 'data-confirm' => 'Are you really sure?']) ?>

        <?php ActiveForm::end() ?>

    </div>
</div>





