<?php

namespace zikwall\easyonline\modules\user\modules\friendship;

use Yii;
use yii\helpers\Url;

class Events extends \yii\base\BaseObject
{
    public static function onAccountMenuInit($event)
    {
        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            $event->sender->addItem(array(
                'label' => Yii::t('FriendshipModule.base', 'Friends'),
                'url' => Url::to(['/friendship/manage']),
                'icon' => '<i class="fa fa-group"></i>',
                'group' => 'account',
                'sortOrder' => 130,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'friendship'),
            ));
        }
    }

}
