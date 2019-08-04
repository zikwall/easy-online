<?php

namespace zikwall\easyonline\modules\admin\permissions;

use zikwall\easyonline\modules\admin\components\BaseAdminPermission;

class ManageSettings extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_manage_settings';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Manage Settings');
        $this->description = \Yii::t('AdminModule.permissions', 'Can manage user- space- and general-settings.');
    }

}
