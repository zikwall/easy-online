<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;

class Notification extends Widget
{
    public $initNotify = false;

    public function run()
    {
        if (!$this->initNotify) {
            return false;
        }

        return $this->render('notification');
    }
}
