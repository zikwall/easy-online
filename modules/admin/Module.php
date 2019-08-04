<?php

namespace zikwall\easyonline\modules\admin;

use zikwall\easyonline\modules\admin\permissions\DefaultAdmin;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'zikwall\easyonline\modules\admin\controllers';

    public function init()
    {
        parent::init();

    }

    public function getName()
    {
        return 'Admin Module';
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        return [
            new DefaultAdmin(),
            new permissions\ManageModules(),
            new permissions\ManageSettings(),
            new permissions\SeeAdminInformation(),
        ];
    }

}
