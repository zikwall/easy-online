<?php

namespace zikwall\easyonline\modules\user\modules\friendship;

use Yii;

class Module extends \zikwall\easyonline\modules\core\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'zikwall\easyonline\modules\user\modules\friendship\controllers';

    /**
     * Returns if the friendship system is enabled
     *
     * @return boolean is enabled
     */
    public function getIsEnabled()
    {
        if (Yii::$app->getModule('user')->getModule('friendship')->settings->get('enable')) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return Yii::t('FriendshipModule.base', 'Friendship');
    }

    public function getPermissions($contentContainer = null)
    {
        return [
            // permissions
        ];
    }

    /**
     * @inheritdoc
     */
    public function getNotifications()
    {
       return [
           'zikwall\easyonline\modules\user\modules\friendship\notifications\Request',
           'zikwall\easyonline\modules\user\modules\friendship\notifications\RequestApproved',
           'zikwall\easyonline\modules\user\modules\friendship\notifications\RequestDeclined'
       ];
    }
}
