<?php

namespace zikwall\easyonline\modules\message\controllers;

use Yii;
use zikwall\easyonline\modules\admin\components\Controller;
use zikwall\easyonline\modules\message\models\Config;
use zikwall\easyonline\modules\core\models\Setting;

class ConfigController extends Controller
{
    public function actionIndex()
    {
        $form = new Config();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            $this->view->saved();
        }

        return $this->render('index', ['model' => $form]);
    }
}

?>
