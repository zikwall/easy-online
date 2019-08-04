<?php

namespace zikwall\easyonline\modules\core\libs;

use yii\base\Event;

class WidgetCreateEvent extends Event
{
    public $config;

    /**
     * @inheritdoc
     */
    public function __construct(&$attributes)
    {
        $this->config = &$attributes;
        $this->init();
    }

}
