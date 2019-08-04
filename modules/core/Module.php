<?php

namespace zikwall\easyonline\modules\core;

use Yii;
use zikwall\easyonline\modules\core\components\EncoreComponent;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    private $_component = null;

    /**
     * @var bool|string|array Module RBAC component.
     */
    public $rbacComponent = true;

    public function getName() : string
    {
        return 'enCore @core Module';
    }

    /**
     * @return EncoreComponent
     */
    public function getEncoreComponent()
    {
        if ($this->_component === null) {
            $this->_component = new EncoreComponent($this);
        }
        return $this->_component;
    }

    public function getRbac()
    {
        return $this->getEncoreComponent()->getComponent('rbac');
    }
}
