<?php

namespace zikwall\easyonline\modules\message;

use zikwall\easyonline\modules\message\permissions\StartConversation;
use zikwall\easyonline\modules\user\models\User;
use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\message\models\MessageEntry;
use zikwall\easyonline\modules\message\models\UserMessage;
use zikwall\easyonline\modules\message\widgets\NewMessageButton;
use zikwall\easyonline\modules\message\widgets\Notifications;
use zikwall\easyonline\modules\message\permissions\SendMail;
use zikwall\easyonline\modules\message\models\Config;

class Events
{
    public static function onUserDelete($event)
    {
        foreach (MessageEntry::findAll(array('user_id' => $event->sender->id)) as $messageEntry) {
            $messageEntry->delete();
        }
        foreach (UserMessage::findAll(array('user_id' => $event->sender->id)) as $userMessage) {
            $userMessage->message->leave($event->sender->id);
        }

        return true;
    }

    public static function onSidebarMenuInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $showInTopNav = false;

        // Workaround for module update problem
        if (method_exists(Config::getModule(), 'showInTopNav')) {
            $showInTopNav = Config::getModule()->showInTopNav();
        }

        if (!Config::getModule()->showInTopNav()){
            $event->sender->addItem([
                'label' => Yii::t('MessageModule.base', 'Messages'),
                'url' => Url::to(['/message/mail/index']),
                //'icon' => '<i class="fa fa-envelope"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'message'),
                'sortOrder' => 300,
            ]);
        }
    }

    public static function onNotificationAddonInit($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        $event->sender->addWidget(Notifications::className(), [], ['sortOrder' => 90]);
    }

    public static function onProfileHeaderControlsInit($event)
    {
        /** @var User $profileContainer */
        $profileContainer = $event->sender->user;

        if ($profileContainer->isCurrentUser() || !Yii::$app->user->can(StartConversation::class)) {
            return;
        }

        // Is the current logged user allowed to send mails to profile user?
        if (!Yii::$app->user->isAdmin() && !$profileContainer->can(SendMail::class)) {
            return;
        }

        $event->sender->addWidget(NewMessageButton::class, ['guid' => $event->sender->user->guid, 'size' => null, 'icon' => null], ['sortOrder' => 90]);
    }

}
