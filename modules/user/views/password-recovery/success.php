<?php

use yii\helpers\Url;

$this->pageTitle = Yii::t('UserModule.views_auth_recoverPassword', 'Password recovery');
?>
<div class="container" style="text-align: center;">
    <div class="row">
        <div class="panel panel-default animated fadeIn" style="max-width: 300px; margin: 0 auto 20px; text-align: left;">
            <div class="panel-heading"><?= Yii::t('UserModule.views_auth_recoverPassword_success', '<strong>Password</strong> recovery!'); ?></div>
            <div class="panel-body">
                <p><?= Yii::t('UserModule.views_auth_recoverPassword_success', "We’ve sent you an email containing a link that will allow you to reset your password."); ?></p><br/>
                <a href="<?= Url::home() ?>" data-ui-loader class="btn btn-primary"><?= Yii::t('UserModule.views_auth_recoverPassword_success', 'back to home') ?></a>
            </div>
        </div>
    </div>
</div>