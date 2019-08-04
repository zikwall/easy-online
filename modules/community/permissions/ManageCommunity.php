<?php

namespace zikwall\easyonline\modules\community\permissions;

use zikwall\easyonline\modules\admin\components\BaseAdminPermission;

class ManageCommunity extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_spaces';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Manage Communities');
        $this->description = \Yii::t('AdminModule.permissions', 'Can manage spaces within the \'Administration -> Communities\' section (create/edit/delete).');
    }

}
