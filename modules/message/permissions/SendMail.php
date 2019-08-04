<?php

namespace zikwall\easyonline\modules\message\permissions;

use zikwall\easyonline\modules\user\models\Group;
use zikwall\easyonline\modules\core\libs\BasePermission;
use zikwall\easyonline\modules\user\models\User;
use Yii;

class SendMail extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'message';

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        User::USERGROUP_USER,
        User::USERGROUP_FRIEND
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        User::USERGROUP_GUEST
    ];

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return Yii::t('MessageModule.base', 'Receive private messages');
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return Yii::t('MessageModule.base', 'Allow others to send you private messages');
    }

    public function getDefaultState($groupId)
    {
        if ($groupId == Group::getAdminGroupId()) {
            return self::STATE_ALLOW;
        }

        return parent::getDefaultState($groupId);
    }

}
