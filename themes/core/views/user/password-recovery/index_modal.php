<?php

use zikwall\easyonline\modules\core\components\compatibility\CActiveForm;

use yii\helpers\Url;
?>

<div class="modal-box-message">
    <b>
        <?= Yii::t('UserModule.views_auth_recoverPassword', 'Just enter your e-mail address. We´ll send you recovery instructions!'); ?>
    </b>
</div>

<?php $form = CActiveForm::begin(['enableClientValidation' => false]); ?>

<div class="form-group">
    <?= $form->textField($model, 'email', ['class' => 'form-control', 'id' => 'email_txt', 'placeholder' => Yii::t('UserModule.views_auth_recoverPassword', 'your email')]); ?>
    <?= $form->error($model, 'email'); ?>
</div>

<div class="form-group">
    <?= \yii\captcha\Captcha::widget([
        'model' => $model,
        'attribute' => 'verifyCode',
        'captchaAction' => '/user/auth/captcha',
        'options' =>['class' => 'form-control', 'placeholder' => Yii::t('UserModule.views_auth_recoverPassword', 'enter security code above')]
    ]);
    ?>
    <?= $form->error($model, 'verifyCode'); ?>
</div>

<hr>
<a href="#" class="btn btn-primary" data-action-click="ui.modal.submit" data-action-url="<?= Url::to(['/user/password-recovery']) ?>" data-ui-loader>
    <?= Yii::t('UserModule.views_auth_recoverPassword', 'Reset password') ?>
</a>
&nbsp;
<a href="#" class="btn btn-default" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/user/auth/login']) ?>" data-ui-loader>
    <?= Yii::t('UserModule.views_auth_recoverPassword', 'Back') ?>
</a>
<?php CActiveForm::end() ?>

<script type="text/javascript">
    <?php if ($model->hasErrors()) { ?>
    $('#password-recovery-form').removeClass('bounceIn');
    $('#password-recovery-form').addClass('shake');
    $('#app-title').removeClass('fadeIn');
    <?php } ?>
</script>
