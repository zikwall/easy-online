<?php

namespace zikwall\easyonline\modules\user\permissions;

use zikwall\easyonline\modules\core\libs\BasePermission;

/**
 * ViewAboutPage Permission
 */
class SuperAdminPermition extends BasePermission
{

        /**
     * @inheritdoc
     */
    protected $id = 'create_private_community';
    
    /**
     * @inheritdoc
     */
    protected $title = "Create private community";

    /**
     * @inheritdoc
     */
    protected $description = "Can create hidden (private) communities.";

    /**
     * @inheritdoc
     */
    protected $moduleId = 'community';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_DENY;

}
