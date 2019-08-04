<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use zikwall\easyonline\modules\user\components\AuthChoice;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('UserModule.users', 'AUTHORISATION')?></div>
    <div class="panel-body">
        <p><?= Yii::t('UserModule.users', 'VIA_SOCIAL_NETWORKS')?></p>
        <p>
            <?= AuthChoice::widget([
                'baseAuthUrl' => ['/user/auth/index']
            ]) ?>
        </p>
        <p><?= Yii::t('UserModule.users', 'OR_BY_PASSWORD')?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-widget-form', 'action' => Url::toRoute('/login')]); ?>
            <div class="row">
                <div class="col-xs-6 col-sm-12">
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="col-xs-6 col-sm-12">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-xs-6 col-sm-12">
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                </div>
                <div class="col-xs-12">
                    <?= Html::submitButton(Yii::t('UserModule.users', 'ENTER'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="panel-footer">
        <a href="<?= Url::toRoute('/user/user/signup')?>"><?= Yii::t('UserModule.users', 'SIGNUP')?></a><br>
        <a href="<?= Url::toRoute('/user/user/request-password-reset')?>"><?= Yii::t('UserModule.users', 'RESET_PASSWORD')?></a>
    </div>
</div>
