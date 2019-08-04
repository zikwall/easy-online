<?php

namespace zikwall\easyonline\modules\ui;

use Yii;
use zikwall\easyonline\modules\core\components\EncoreComponent;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    /**
     * @var bool
     */
    private $enableSidebar = true;

    /**
     * @return bool
     */
    public function getEnabledSidebar() : bool
    {
        return $this->enableSidebar;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function setEnabledSidebar(bool $status) : Module
    {
        $this->enableSidebar = $status;
        return $this;
    }

    public function getName()
    {
        return parent::getName();
    }
}
