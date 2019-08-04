<?php

namespace zikwall\easyonline\modules\user\notifications;

use Yii;
use yii\bootstrap\Html;
use zikwall\easyonline\modules\notification\components\BaseNotification;

class Followed extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'user';

    /**
     * @inheritdoc
     */
    public $viewName = 'followed';

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new FollowedNotificationCategory();
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->originator->getUrl();
    }

    /**
     * @inheritdoc
     */
    public function getMailSubject()
    {
        return strip_tags($this->html());
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Yii::t('UserModule.notification', '{displayName} is now following you.', [
                    'displayName' => Html::tag('strong', Html::encode($this->originator->displayName)),
        ]);
    }

}

?>
