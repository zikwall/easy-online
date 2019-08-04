<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\widgets\AuthChoice;

$this->registerJs('$(document).on("ready pjax:success", function () {$("#login_username").focus();});', \yii\web\View::POS_END);
?>

<div class="modal-box-message">
    <b>Пожалуйста, укажите Ваше имя и&nbsp;фамилию.</b>
    <br>
    Чтобы облегчить общение и поиск друзей, у&nbsp;нас приняты настоящие имена и фамилии.
</div>
<?php if ($canRegister) : ?>
    <div class="text-center modal-body">
        <h2 class="ui_block_h2 ">
            <ul class="ui_tabs clear_fix blog_about_tabs page_header_wrap" data-tabs="tabs">
                <li class="tab-login" data-toggle="tab">
                    <a class="tab-a ui_tab <?= (!isset($_POST['Invite'])) ? "ui_tab_sel" : ""; ?>" data-id="login" onclick="openForm(event, 'login')">
                        <?= Yii::t('UserModule.views_login_invite', 'Login'); ?>
                    </a>
                </li>
                <li class="tab-register" role="tab" data-toggle="tab">
                    <a class="tab-a ui_tab <?= (isset($_POST['Invite'])) ? "ui_tab_sel" : ""; ?>" data-id="register" onclick="openForm(event, 'register')">
                        <?= Yii::t('UserModule.views_login_invite', 'New user?'); ?>
                    </a>
                </li>
                <div class="ui_tabs_slider _ui_tabs_slider" style="width: 200px; margin-left: 80px;"></div>
            </ul>
        </h2>
    </div>
<?php endif; ?>
<br>
<div class="tab-content">
    <div id="login" class="tabcontent tabcontent-active">
        <?php if (AuthChoice::hasClients()): ?>
            <?= AuthChoice::widget([]) ?>
        <?php else: ?>
            <?php if ($canRegister) : ?>
                <p><?= Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
            <?php else: ?>
                <p><?= Yii::t('UserModule.views_auth_login', "Please login with your username/email and password."); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
        <?= $form->field($model, 'username')->textInput(['id' => 'login_username', 'placeholder' => Yii::t('UserModule.views_auth_login', 'username or email')]); ?>
        <?= $form->field($model, 'password')->passwordInput(['id' => 'login_password', 'placeholder' => Yii::t('UserModule.views_auth_login', 'password')]); ?>
        <?= $form->field($model, 'rememberMe')->checkbox(); ?>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <button href="#" id="loginBtn" data-ui-loader type="submit" class="btn btn-primary" data-action-click="ui.modal.submit" data-action-url="<?= Url::to(['/user/auth/login']) ?>">
                    <?= Yii::t('UserModule.views_auth_login', 'Sign in') ?>
                </button>

            </div>
            <div class="col-md-8 text-right">
                <small>
                    <?= Yii::t('UserModule.views_auth_login', 'Forgot your password?'); ?>
                    <br/>
                    <a id="recoverPasswordBtn" href="<?= Url::to(['/user/password-recovery']) ?>" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/user/password-recovery']) ?>">
                        <?= Yii::t('UserModule.views_auth_login', 'Create a new one.') ?>
                    </a>
                </small>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <?php if ($canRegister) : ?>
        <div id="register" class="tabcontent <?= (isset($_POST['Invite'])) ? "tabcontent-active" : ""; ?>">
            <p><?= Yii::t('UserModule.views_auth_login', "Don't have an account? Join the network by entering your e-mail address."); ?></p>
            <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

            <?= $form->field($invite, 'email')->input('email', ['id' => 'register-email', 'placeholder' => Yii::t('UserModule.views_auth_login', 'email')]); ?>
            <hr>

            <a href="#" class="btn btn-primary" data-ui-loader data-action-click="ui.modal.submit" data-action-url="<?= Url::to(['/user/auth/login']) ?>">
                <?= Yii::t('UserModule.views_auth_login', 'Register') ?>
            </a>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>
