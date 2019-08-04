<?php

namespace zikwall\easyonline\modules\message;

use zikwall\easyonline\modules\message\permissions\StartConversation;
use zikwall\easyonline\modules\message\permissions\SendMail;
use zikwall\easyonline\modules\user\models\User;
use yii\helpers\Url;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    /**
     * @inheritdoc
     */
    public $resourcesPath = 'resources';

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/message/config']);
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if (!$contentContainer) {
            return [
                new StartConversation()
            ];
        } else if ($contentContainer instanceof User) {
            return [
                new SendMail()
            ];
        }

        return [];
    }

    public function showInTopNav()
    {
        return !$this->settings->get('showInTopNav', false);
    }

}
