<?php

namespace zikwall\easyonline\modules\admin\permissions;

use zikwall\easyonline\modules\admin\components\BaseAdminPermission;

class SeeAdminInformation extends BaseAdminPermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'admin_see_information';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->title = \Yii::t('AdminModule.permissions', 'Access Admin Information');
        $this->description = \Yii::t('AdminModule.permissions', 'Can access the \'Administration -> Information\' section.');
    }

}
