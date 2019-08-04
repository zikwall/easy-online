<?php

namespace zikwall\easyonline\modules\admin\components;

use zikwall\easyonline\modules\user\models\Group;

class BaseAdminPermission extends \zikwall\easyonline\modules\core\libs\BasePermission
{
    /**
     * @inheritdoc
     */
    protected $moduleId = 'admin';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_DENY;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->fixedGroups[] = Group::getAdminGroupId();

        parent::init();
    }

    public function getDefaultState($groupId)
    {
        if ($groupId == Group::getAdminGroupId()) {
            return self::STATE_ALLOW;
        }

        return parent::getDefaultState($groupId);
    }

}
