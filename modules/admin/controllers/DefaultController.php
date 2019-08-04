<?php

namespace zikwall\easyonline\modules\admin\controllers;

class DefaultController extends \zikwall\easyonline\modules\admin\components\Controller
{
    public function actionTest()
    {
        return $this->renderAjax('test', []);
    }
}
