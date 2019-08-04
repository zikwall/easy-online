<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;

class Photo extends Widget
{
    public function run()
    {
        return $this->render('photo');
    }
}
