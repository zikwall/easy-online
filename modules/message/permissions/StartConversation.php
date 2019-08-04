<?php

namespace zikwall\easyonline\modules\message\permissions;

use zikwall\easyonline\modules\core\libs\BasePermission;
use zikwall\easyonline\modules\user\models\User;
use Yii;

class StartConversation extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'message';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('MessageModule.base', 'Start new conversations');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('MessageModule.base', 'Allow users to start new conversations');
    }

}
