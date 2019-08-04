<?php
/**
 * @var $hForm \zikwall\easyonline\modules\core\components\compatibility\HForm;
 */
?>
<?php $this->beginContent('@user/views/account/_userProfileLayout.php') ?>
    <div class="help-block">
        <?= Yii::t('UserModule.views_account_edit', 'Here you can edit your general profile data, which is visible in the about page of your profile.'); ?>
    </div>
    <?php $form = \yii\bootstrap\ActiveForm::begin(['enableClientValidation' => false, 'options' => ['data-ui-widget' => 'ui.form.TabbedForm', 'data-ui-init' => '']]); ?>
        <?= $hForm->render($form); ?>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
<?php $this->endContent(); ?>

