<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\widgets\AuthChoice;
use zikwall\easyonline\modules\core\components\compatibility\CHtml;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \zikwall\easyonline\modules\core\models\LoginForm */
?>

<style>
    .index_rcolumn {
        float: inherit;
        width: 320px;
        min-height: 625px;
        margin: 0 auto;
        display: block;
    }
    .index_rcolumn .page_block:first-child {
        margin-top: 0;
    }
    .index_rcolumn .page_block {
        margin: 30px 0 20px;
        padding: 25px;
    }
    .index_rcolumn .page_block {
        margin: 30px 0 20px;
        padding: 25px;
    }
    .ij_header {
        margin: -4px 0 0;
        font-size: 20px;
        font-weight: 500;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
        text-align: center;
    }
    .ij_subheader {
        padding: 5px 0 21px;
        text-align: center;
        color: #656565;
        font-size: 12.5px;
    }
    .index_rcolumn .forgot {
        display: inline-block;
        padding-top: 12px;
        text-align: center;
        width: 100%;
    }
    .index_rcolumn .checkbox, .index_rcolumn .index_forgot {
        line-height: 20px;
    }

    .authChoiceMore {
        display: none;
        padding-top: 6px;
    }
    .authChoiceMore a {
        margin-top: 6px !important;
    }
    .or-container {
        text-align: center;
        margin: 0;
        margin-top: 0px;
        margin-top: -10px;
        padding: 0;
        clear: both;
        color: #6a737c;
        font-variant: small-caps;
    }
    .or-container hr {
        margin-bottom: 0;
        position: relative;
        top: 19px;
        height: 0;
        border: 0;
        border-top-width: 0px;
        border-top-style: none;
        border-top-color: currentcolor;
        border-top: 1px solid #e4e6e8;
    }
    .or-container div {
        display: inline-block;
        position: relative;
        padding: 8px;
        background-color: #FFF;
    }
    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }
</style>

<div id="index_rcolumn" class="index_rcolumn">
    <div id="index_login" class="page_block index_login">
        <?php if (AuthChoice::hasClients()): ?>
            <?= AuthChoice::widget([]) ?>
        <?php else: ?>
            <?php if ($canRegister) : ?>
                <p><?= Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
            <?php else: ?>
                <p><?= Yii::t('UserModule.views_auth_login', "Please login with your username/email and password."); ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['id' => 'login_username', 'placeholder' => Yii::t('UserModule.views_auth_login', 'username or email')]); ?>
        <?= $form->field($model, 'password')->passwordInput(['id' => 'login_password', 'placeholder' => Yii::t('UserModule.views_auth_login', 'password')]); ?>
        <?= $form->field($model, 'rememberMe')->checkbox(); ?>
        <button href="#" id="loginBtn" data-ui-loader type="submit" class="btn btn-primary">
            <?= Yii::t('UserModule.views_auth_login', 'Sign in') ?>
        </button>
        <hr>
        <div class="forgot">
            <span class="float_left">
                <?= Yii::t('UserModule.views_auth_login', 'Forgot your password?'); ?>
            </span>
            <a class="index_forgot hover_underline float_right" id="recoverPasswordBtn" href="<?= Url::to(['/user/password-recovery']) ?>" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/user/password-recovery']) ?>">
                <?= Yii::t('UserModule.views_auth_login', 'Create a new one.') ?>
            </a>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php if ($canRegister) : ?>
        <div id="ij_form" class="page_block ij_form">
            <h2 class="ij_header">Впервые ВСистеме?</h2>
            <div class="ij_subheader">
                <?= Yii::t('UserModule.views_auth_login', "Don't have an account? Join the network by entering your e-mail address."); ?>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'invite-form']); ?>

            <?= $form->field($invite, 'email')->input('email', ['id' => 'register-email', 'placeholder' => Yii::t('UserModule.views_auth_login', 'email')]); ?>
            <hr>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('UserModule.views_auth_login', 'Register'),
                    [
                        'id' => 'register-submit-btn',
                        'class' => 'btn btn-primary',
                        'data-ui-loader' => ''
                    ]); ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function(){
        $("#btnAuthChoiceMore").click(function () {
            $("#btnAuthChoiceMore").hide();
            $(".authChoiceMore").show();
        });
    });
</script>

