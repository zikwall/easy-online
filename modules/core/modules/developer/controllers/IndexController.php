<?php

namespace zikwall\easyonline\modules\core\modules\developer\controllers;

use Yii;
use zikwall\easyonline\modules\core\components\base\Controller;

class IndexController extends Controller
{
    public $subLayout = "@zikwall/easyonline/modules/core/modules/developer/views/index/_layout";

    public function actionIndex()
    {
        return $this->render('index');
    }
}

?>
