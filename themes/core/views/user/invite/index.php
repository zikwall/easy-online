<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<?= Yii::t('UserModule.invite', 'Please add the email addresses of people you want to invite below.'); ?>
<br/><br/>
<div class="form-group">
    <?= $form->field($model, 'emails')->textarea(['rows' => '3', 'placeholder' => Yii::t('UserModule.invite', 'Email address(es)'), 'id' => 'emails'])->label(false)->hint(Yii::t('UserModule.invite', 'Separate multiple email addresses by comma.')); ?>
</div>


<div class="modal-footer">
    <a href="#" class="btn btn-primary" data-action-click="ui.modal.submit" data-action-url="<?= Url::to(['/user/invite']) ?>" data-ui-loader>
        <?= Yii::t('UserModule.invite', 'Send invite') ?>
    </a>
</div>

<?php ActiveForm::end(); ?>
