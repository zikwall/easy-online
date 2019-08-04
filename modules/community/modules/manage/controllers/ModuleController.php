<?php


namespace zikwall\easyonline\modules\community\modules\manage\controllers;

use Yii;
use zikwall\easyonline\modules\community\modules\manage\components\Controller;

class ModuleController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $community = $this->getCommunity();
        return $this->render('index', ['availableModules' => $community->getAvailableModules(), 'community' => $community]);
    }

    public function actionEnable()
    {
        $this->enableCsrfValidation = false;

        $this->forcePostRequest();

        $community = $this->getCommunity();

        $moduleId = Yii::$app->request->get('moduleId', "");

        if (!$community->isModuleEnabled($moduleId)) {
            $community->enableModule($moduleId);
        }

        if (!Yii::$app->request->isAjax) {
            return $this->redirect($community->createUrl('/community/manage/module'));
        } else {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }
    }

    public function actionDisable()
    {
        $this->enableCsrfValidation = false;

        $this->forcePostRequest();

        $community = $this->getCommunity();

        $moduleId = Yii::$app->request->get('moduleId', "");

        if ($community->isModuleEnabled($moduleId) && $community->canDisableModule($moduleId)) {
            $community->disableModule($moduleId);
        }

        if (!Yii::$app->request->isAjax) {
            return $this->redirect($community->createUrl('/community/manage/module'));
        } else {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }
    }
}

?>
