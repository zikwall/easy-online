<?php

namespace zikwall\easyonline\modules\installer\controllers;

use zikwall\easyonline\modules\core\components\base\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', []);
    }
    
    public function actionGo()
    {
        if ($this->module->checkDBConnection()) {
            return $this->redirect(['setup/init']);
        } else {
            return $this->redirect(['setup/prerequisites']);
        }
    }

}
