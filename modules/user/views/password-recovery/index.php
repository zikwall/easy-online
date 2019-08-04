<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 27.04.2017
 * Time: 11:18
 */
use \yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use zikwall\easyonline\modules\core\components\compatibility\CActiveForm;
use zikwall\easyonline\modules\user\widgets\AuthChoice;
use zikwall\easyonline\modules\core\components\CHtml;

$this->registerCssFile('/static/metronic/pages/css/login-2.min.css');
$this->registerCssFile('/static/metronic/pages/scripts/login.min.js');

$this->title = 'Сброс пароля в системе - АИС Университет';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = CActiveForm::begin(['enableClientValidation' => false]); ?>
    <div class="form-title">
        <span class="form-title">Востановление пароля</span>
    </div>
    <div class="form-group">
        <p class="hint"> <?= Yii::t('UserModule.views_auth_recoverPassword', 'Just enter your e-mail address. We´ll send you recovery instructions!'); ?> </p>
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-solid placeholder-no-fix',
                                 'id' => 'email_txt',
                                 'placeholder' => Yii::t('UserModule.views_auth_recoverPassword', 'your email')])->label(false) ?>
    </div>
    <div class="form-group">
        <?=\yii\captcha\Captcha::widget([
            'model' => $model,
            'attribute' => 'verifyCode',
            'captchaAction' => '/user/auth/captcha',
            'options' => ['class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => Yii::t('UserModule.views_auth_recoverPassword', 'enter security code above')]
        ]);
        ?>
        <div class="help-block"><?= $form->error($model, 'verifyCode'); ?></div>
    </div>
    <div class="form-group">
        <!--<p class="hint"> Enter your account details below: </p>-->
        <div class="form-actions">
            <?= Html::submitButton(Yii::t('UserModule.views_auth_recoverPassword', 'Reset password'), ['class' => 'btn red uppercase pull-right', 'data-ui-loader' => ""]); ?> <a class="btn btn-primary" data-ui-loader href="<?= Url::home(); ?>"><?= Yii::t('UserModule.views_auth_recoverPassword', 'Back') ?></a>
        </div>
    </div>
    <?php CActiveForm::end(); ?>
    <!-- END LOGIN FORM -->
</div>

<script type="text/javascript">

    $(function () {
        // set cursor to email field
        $('#email_txt').focus();
    });

    // Shake panel after wrong validation
    <?php if ($model->hasErrors()) : ?>
    $('#password-recovery-form').removeClass('bounceIn');
    $('#password-recovery-form').addClass('shake');
    $('#app-title').removeClass('fadeIn');
    <?php endif; ?>
</script>
