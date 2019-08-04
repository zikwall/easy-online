<?php

use yii\widgets\ActiveForm;
use zikwall\easyonline\modules\core\helpers\TimezoneHelper;

?>

<?php $this->beginContent('@user/views/account/_userSettingsLayout.php') ?>

<?php $form = ActiveForm::begin(['id' => 'basic-settings-form']); ?>

<?= $form->field($model, 'tags'); ?>

<?php if (count($languages) > 1) : ?>
    <?= $form->field($model, 'language')->dropDownList($languages, ['data-ui-select2' => '']); ?>
<?php endif; ?>

<?= $form->field($model, 'timeZone')->dropDownList(TimezoneHelper::generateList()); ?>

<?php if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess')): ?>

    <?= $form->field($model, 'visibility')->dropDownList([
        1 => Yii::t('UserModule.views_account_editSettings', 'Registered users only'),
        2 => Yii::t('UserModule.views_account_editSettings', 'Visible for all (also unregistered users)'),
    ]);
    ?>

<?php endif; ?>

<button class="btn btn-primary" type="submit" data-ui-loader><?= Yii::t('UserModule.views_account_editSettings', 'Save') ?></button>

<?php ActiveForm::end(); ?>
<?php $this->endContent(); ?>
