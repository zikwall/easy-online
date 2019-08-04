<?php

use zikwall\easyonline\modules\user\widgets\UserPickerField;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use zikwall\easyonline\modules\ui\widgets\ModalButton;


/* @var $model \zikwall\easyonline\modules\message\models\forms\CreateMessage */
?>


<div class="modal-dialog">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t('MessageModule.views_mail_create', 'New message'); ?></h4>
        </div>

        <div class="modal-body">

            <?= $form->field($model, 'recipient')->widget(UserPickerField::class,
                [
                    'url' => Url::toRoute(['/mail/mail/search-user']),
                    'placeholder' => Yii::t('MessageModule.views_mail_create', 'Add recipients'),
                    'focus' => true
                ]
            );?>

            <?= $form->field($model, 'title'); ?>

            <?= $form->field($model, 'message')->textInput(
                [
                'menuClass' => 'plainMenu',
                'placeholder' => Yii::t('MessageModule.base', 'Write a message...'),
                'pluginOptions' => ['maxHeight' => '300px'],
            ])->label(false) ?>

        </div>
        <div class="modal-footer">

            <?= ModalButton::submitModal(Url::to(['/mail/mail/create']), Yii::t('MessageModule.views_mail_create', 'Send'))?>
            <?= ModalButton::cancel()?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


<script type="text/javascript">
    // set focus to input for space name
    $('#recipient').focus();
</script>
