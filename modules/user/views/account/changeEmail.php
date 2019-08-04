<?php

use yii\widgets\ActiveForm;
use zikwall\easyonline\modules\core\components\compatibility\CHtml;
use zikwall\easyonline\modules\core\widgets\DataSaved;
?>

<?php $this->beginContent('@user/views/account/_userProfileLayout.php') ?>
    <div class="help-block">
         <?= Yii::t('UserModule.views_account_changeEmail', 'Your current E-mail address is <b>{email}</b>. You can change your current E-mail address here.', ['email' => CHtml::encode(Yii::$app->user->getIdentity()->email)]); ?>
    </div>
    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isAttributeRequired('currentPassword')): ?>
        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => 45]); ?>
    <?php endif; ?>

    <?= $form->field($model, 'newEmail')->textInput(['maxlength' => 45]); ?>

    <hr>
    <?= CHtml::submitButton(Yii::t('UserModule.views_account_changeEmail', 'Save'), array('class' => 'btn btn-primary', 'data-ui-loader' => '')); ?>

    <!-- show flash message after saving -->
    <?= DataSaved::widget(); ?>

    <?php ActiveForm::end(); ?>
<?php $this->endContent(); ?>




