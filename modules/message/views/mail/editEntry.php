<?php

use yii\bootstrap\ActiveForm;
use zikwall\easyonline\modules\ui\widgets\ModalDialog;
use zikwall\easyonline\modules\core\widgets\Button;
use zikwall\easyonline\modules\ui\widgets\ModalButton;

/* @var $entry \zikwall\easyonline\modules\message\models\MessageEntry */

?>

<?php ModalDialog::begin(['header' => Yii::t("MessageModule.views_mail_edit", "Edit message entry"), 'size' => 'large']) ?>

    <?php $form = ActiveForm::begin() ?>
        <div class="modal-body mail-edit-message">
            <?= $form->field($entry, 'content')->textInput([
                'placeholder' => Yii::t('MessageModule.base', 'Edit message...'),
                'pluginOptions' => ['maxHeight' => '300px'],
            ])->label(false) ?>
        </div>
        <div class="modal-footer">

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <?= Button::save(Yii::t('base', 'Save'))->submit()->action('mail.wall.submitEditEntry')->options(['data-entry-id' => $entry->id]) ?>
                    <?= ModalButton::cancel() ?>
                </div>
                <div class="col-md-3">
                    <?= Button::danger(Yii::t('base', 'Delete'))->right()->options(['data-entry-id' => $entry->id])
                        ->action('mail.wall.deleteEntry')
                        ->confirm(Yii::t('MessageModule.views_mail_show', '<strong>Confirm</strong> message deletion'),
                            Yii::t('MessageModule.views_mail_show', 'Do you really want to delete this message?'),
                            Yii::t('MessageModule.views_mail_show', 'Delete'),
                            Yii::t('MessageModule.views_mail_show', 'Cancel')) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?>

<?php ModalDialog::end() ?>
