<?php

use zikwall\easyonline\modules\message\assets\MailAsset;
use zikwall\easyonline\modules\message\permissions\StartConversation;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \zikwall\easyonline\modules\core\components\base\View */

MailAsset::register($this);

$canStartConversation = Yii::$app->user->can(StartConversation::class);

?>
<div class="btn-group">
    <a href="#" id="icon-messages" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i></a>
    <span id="badge-messages" style="display:none;" class="label label-danger label-notification"></span>
    <ul id="dropdown-messages" class="dropdown-menu">
        <li class="dropdown-header">
            <div class="arrow"></div><?= Yii::t('MessageModule.widgets_views_mailNotification', 'Messages'); ?> <?= ($canStartConversation) ? Html::a(Yii::t('MessageModule.widgets_views_mailNotification', 'New message'), Url::to(['/mail/mail/create', 'ajax' => 1]), ['class' => 'btn btn-info btn-xs', 'id' => 'create-message-button', 'data-target' => '#globalModal']) : '' ?>
        </li>
        <ul class="media-list">
            <li id="loader_messages">

            </li>
        </ul>
        <li>
            <div class="dropdown-footer">
                <a class="btn btn-default col-md-12" href="<?= Url::to(['/mail/mail/index']); ?>">
                    <?= Yii::t('MessageModule.widgets_views_mailNotification', 'Show all messages'); ?>
                </a>
            </div>
        </li>
    </ul>
</div>

<script type="text/javascript">

</script>

