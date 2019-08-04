<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\widgets\AuthChoice;
use zikwall\easyonline\modules\core\components\compatibility\CHtml;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \zikwall\easyonline\modules\core\models\LoginForm */

$this->title = Yii::t('UserModule.users', 'LOGIN');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <?= Yii::$app->session->getFlash('error'); ?>
    <?= Yii::$app->session->getFlash('success'); ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="col-lg-5">
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?= Yii::t('UserModule.users', 'YOU_CAN_RESET_PASSWORD', ['url' => Url::toRoute('/user/user/request-password-reset')])?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('UserModule.users', 'LOGIN'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <div class="col-lg-7">
            <p><?= Yii::t('UserModule.users', 'YOU_CAN_ENTER_VIA_SOCIAL_NETWORKS')?></p>
            <?php if (AuthChoice::hasClients()): ?>
                <?= AuthChoice::widget([]) ?>
            <?php else: ?>
                <?php if ($canRegister) : ?>
                    <p><?= Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
                <?php else: ?>
                    <p><?= Yii::t('UserModule.views_auth_login', "Please login with your username/email and password."); ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($canRegister) : ?>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" class="btn-primary btn" id="register-btn">Создать аккаунт</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php if ($canRegister) : ?>
        <?php $form = ActiveForm::begin(['id' => 'invite-form', 'class' => 'register-form']); ?>
        <center>
            <div class="form-title">
                <span class="form-title">Регистрация</span>
            </div>
        </center>
        <p class="hint"> <?= Yii::t('UserModule.views_auth_login', "Don't have an account? Join the network by entering your e-mail address."); ?> </p>
        <?= $form->field($invite, 'email')
            ->input('email', ['class' => 'form-control placeholder-no-fix' ,'id' => 'register-email','placeholder' => $invite->getAttributeLabel('email')])
            ->label(false); ?>

        <div class="form-group">
            <!--<p class="hint"> Enter your account details below: </p>-->
            <div class="form-actions">
                <button type="button" id="register-back-btn" class="btn btn-default">Отмена</button>

                <?= CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Register'),
                    [
                        'id' => 'register-submit-btn',
                        'class' => 'btn red uppercase pull-right',
                        'data-ui-loader' => ''
                    ]); ?>

            </div>
            <?php ActiveForm::end(); ?>
            <?php endif; ?>
        </div>
    </div>
