<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 18.11.2018
 * Time: 15:21
 */

namespace zikwall\easyonline\modules\user\widgets;

use zikwall\easyonline\modules\core\widgets\BaseStack;

class Gifts extends BaseStack
{
    public function run()
    {
        return $this->render('gifts');
    }
}
