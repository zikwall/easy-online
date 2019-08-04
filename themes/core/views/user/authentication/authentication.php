<?php

use yii\bootstrap\ActiveForm;
use zikwall\easyonline\modules\core\libs\Html;
use zikwall\easyonline\modules\core\models\Setting;
?>

<?php $this->beginContent('@easyonline/modules/user/views/authentication/_authenticationLayout.php') ?>
    <?php $form = ActiveForm::begin(['id' => 'authentication-settings-form']); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'allowGuestAccess')->checkbox(); ?>

    <?= $form->field($model, 'internalAllowAnonymousRegistration')->checkbox(); ?>

    <?= $form->field($model, 'internalUsersCanInvite')->checkbox(); ?>

    <?= $form->field($model, 'internalRequireApprovalAfterRegistration')->checkbox(); ?>

    <?= $form->field($model, 'defaultUserGroup')->dropDownList($groups, ['readonly' => Setting::IsFixed('auth.defaultUserGroup', 'user')]); ?>

    <?= $form->field($model, 'defaultUserIdleTimeoutSec')->textInput(['readonly' => Setting::IsFixed('auth.defaultUserIdleTimeoutSec', 'user')]); ?>
    <p class="help-block"><?= Yii::t('AdminModule.views_setting_authentication', 'Min value is 20 seconds. If not set, session will timeout after 1400 seconds (24 minutes) regardless of activity (default session timeout)'); ?></p>

    <?= $form->field($model, 'defaultUserProfileVisibility')->dropDownList([1 => Yii::t('AdminModule.views_setting_authentication', 'Visible for members only'), 2 => Yii::t('AdminModule.views_setting_authentication', 'Visible for members+guests')], ['readonly' => (!Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess'))]); ?>
    <p class="help-block"><?= Yii::t('AdminModule.views_setting_authentication', 'Only applicable when limited access for non-authenticated users is enabled. Only affects new users.'); ?></p>

    <hr>

    <?= Html::submitButton(Yii::t('AdminModule.views_setting_authentication', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => ""]); ?>

    <?php ActiveForm::end(); ?>

<?php $this->endContent(); ?>
