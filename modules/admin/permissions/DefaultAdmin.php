<?php

namespace zikwall\easyonline\modules\admin\permissions;

use zikwall\easyonline\modules\admin\components\BaseAdminPermission;

class DefaultAdmin extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_default_permission';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Default Admin');
        $this->description = \Yii::t('AdminModule.permissions', 'Default administrator permission');
    }

}
