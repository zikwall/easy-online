<?php

use yii\helpers\Url;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?= Yii::t('UserModule.views_auth_recoverPassword', '<strong>Password</strong> recovery'); ?></h4>
        </div>
        <div class="modal-body">
            <p><?= Yii::t('UserModule.views_auth_recoverPassword_success', "We’ve sent you an email containing a link that will allow you to reset your password."); ?></p><br/>
            <a href="<?= Url::home(); ?>" data-ui-loader data-pjax-prevent class="btn btn-primary"><?= Yii::t('UserModule.views_auth_recoverPassword_success', 'back to home') ?></a>
        </div>
    </div>
</div>    