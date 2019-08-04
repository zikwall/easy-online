<?php

namespace zikwall\easyonline\modules\user\notifications;

use Yii;
use zikwall\easyonline\modules\notification\components\NotificationCategory;

/**
 * Description of FollowingNotificationCategory
 *
 * @author buddha
 */
class FollowedNotificationCategory extends NotificationCategory
{

    /**
     * @inheritdoc
     */
    public $id = 'followed';

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('UserModule.notifications_FollowingNotificationCategory', 'Following');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('UserModule.notifications_FollowingNotificationCategory', 'Receive Notifications when someone is following you.');
    }

}
