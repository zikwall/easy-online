<?php

use zikwall\easyonline\modules\core\libs\Html;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="media">
            <span class="label label-default pull-right"><?= Yii::t('UserModule.base', 'User'); ?></span>
            <div class="media-body">
                <h4 class="media-heading"><?= Html::containerLink($user); ?></h4>
                <h5><?= Html::encode($user->displayName); ?></h5>
            </div>
        </div>
    </div>
</div>
