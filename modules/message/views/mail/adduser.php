<?php

use yii\widgets\ActiveForm;
use zikwall\easyonline\modules\core\widgets\ModalDialog;
use zikwall\easyonline\modules\user\widgets\UserPickerField;
use zikwall\easyonline\modules\ui\widgets\ModalButton;
use zikwall\easyonline\modules\core\widgets\Buttonn;

/* @var $inviteForm \zikwall\easyonline\modules\message\models\forms\InviteParticipantForm */
?>


<?php ModalDialog::begin(['header' => Yii::t("MessageModule.views_mail_adduser", "Add more participants to your conversation...")])?>

    <?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
        <div class="modal-body">
            <div class="form-group">
                <?= $form->field($inviteForm, 'recipients')->widget(UserPickerField::class, [
                        'url' => $inviteForm->getPickerUrl(), 'focus' => true
                ])->label(false); ?>
            </div>
        </div>
        <div class="modal-footer">
            <?= ModalButton::save()->submit()->action('addUser', $inviteForm->getUrl(), '#mail-conversation-root')->close() ?>
            <?= ModalButton::cancel() ?>
        </div>
    <?php ActiveForm::end() ?>

<?php ModalDialog::end() ?>
