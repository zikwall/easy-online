<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use zikwall\easyonline\modules\user\widgets\UserPickerField;
?>

<?php $this->beginContent('@zikwall/easyonline/modules/user/views/group/_manageLayout.php', ['group' => $group]) ?>

    <div class="card-content">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($group, 'name'); ?>
        <?= $form->field($group, 'description')->textarea(['rows' => 5]); ?>

        <?php if ($isManagerApprovalSetting && !$group->is_admin_group): ?>
            <?php $url = ($group->isNewRecord) ? null : Url::to(['/user/group/admin-user-search', 'id' => $group->id]); ?>
            <?=  UserPickerField::widget([
                'form' => $form,
                'model' => $group,
                'attribute' => 'managerGuids',
                'selection' => $group->manager,
                'url' => $url
            ])
            ?>
        <?php endif; ?>

        <strong><?= Yii::t('AdminModule.views_group_edit', 'Visibility'); ?></strong>

        <?php if (!$group->is_admin_group): ?>
            <?= $form->field($group, 'show_at_registration')->checkbox(); ?>
        <?php endif; ?>


        <?= $form->field($group, 'show_at_directory')->checkbox(); ?>

        <?= Html::submitButton(Yii::t('AdminModule.views_group_edit', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => ""]); ?>

        <?php
        if ($showDeleteButton) {
            echo Html::a(Yii::t('AdminModule.views_group_edit', 'Delete'), Url::toRoute(['/user/community/delete', 'id' => $group->id]), ['class' => 'btn btn-danger', 'data-method' => 'POST']);
        }
        ?>
        <?php ActiveForm::end(); ?>

    </div>

<?php $this->endContent(); ?>
