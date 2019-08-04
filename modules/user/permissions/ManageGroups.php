<?php

namespace zikwall\easyonline\modules\user\permissions;

use zikwall\easyonline\modules\admin\components\BaseAdminPermission;

/**
 * ManageUsersAdvanced Permission allows access to users/userstab section within the admin area.
 */
class ManageGroups extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_groups';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Manage Groups');
        $this->description = \Yii::t('AdminModule.permissions', 'Can manage users and groups');
    }

}
