<?php

namespace zikwall\easyonline\modules\user;

use Yii;
use yii\helpers\Url;
use yii\base\BaseObject;

class Events extends BaseObject
{
    public static function onBeforeRequest($event)
    {
        Yii::$app->urlManager->addRules([
            ['pattern' => 'communities', 'route' => 'user/community/my'],
            ['pattern' => 'registration/<token:\w+>', 'route' => '/user/registration/index'],
        ], true);
    }

    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Users'),
            'url' => Url::toRoute(['/user/admin']),
            'sortOrder' => 99999200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user'),
        ]);
    }

    public static function onSidebarInit($event)
    {
        if (Yii::$app->user->getIsGuest()) {
            return true;
        }

        $user = Yii::$app->user->getIdentity();

        $event->sender->addItem([
            'label' => 'Мой профиль',
            'url' => $user->createUrl('/user/profile/home'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user'
                && Yii::$app->controller->id == 'profile')
        ]);

        $event->sender->addItem([
            'label' => 'Сообщества',
            'url' => Url::toRoute(['/user/community/my']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user'
                && Yii::$app->controller->id == 'community'
                && Yii::$app->controller->action->id == 'my')
        ]);
    }
}
