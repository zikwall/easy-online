<?php

namespace zikwall\easyonline\modules\admin\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\HttpException;
use zikwall\easyonline\modules\admin\permissions\ManageModules;
use zikwall\easyonline\modules\ui\widgets\ContentModalDialog;

class ModuleController extends \zikwall\easyonline\modules\admin\components\Controller
{
    public $adminOnly = false;

    public function init()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Modules'));
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
           // ['permissions' => ManageModules::class]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->actionList();
    }

    public function actionList()
    {
        return $this->render('list', [
            'installedModules' => \Yii::$app->moduleManager->getModules()
        ]);
    }

    public function actionInfo()
    {
        $moduleId = Yii::$app->request->get('moduleId');
        $module = Yii::$app->moduleManager->getModule($moduleId);

        if ($module == null) {
            throw new HttpException(500, 'Could not find requested module!');
        }

        $readmeMd = "";
        $readmeMdFile = $module->getBasePath() . DIRECTORY_SEPARATOR . 'README.md';
        if (file_exists($readmeMdFile)) {
            $readmeMd = file_get_contents($readmeMdFile);
        }

        return ContentModalDialog::widget([
            'content' => $this->renderAjax('info', [
                'name' => Yii::t('AdminModule.views_module_info', '<strong>Module</strong> details', ['%moduleName%' => Html::encode($module->getName())]),
                'description' => $module->getDescription(),
                'content' => $readmeMd
            ]),
            'title' => 'Выберите Ваш язык'
        ]);
    }

    public function actionEnable()
    {
        // $this->forcePostRequest();

        $moduleId = Yii::$app->request->get('moduleId');
        $module = Yii::$app->moduleManager->getModule($moduleId);

        if ($module == null) {
            throw new HttpException(500, 'Could not find requested module!');
        }

        $module->enable();

        return $this->redirect(Url::to('/admin/module/list'));
    }

    public function actionDisable()
    {

        //$this->forcePostRequest();

        $moduleId = Yii::$app->request->get('moduleId');
        $module = Yii::$app->moduleManager->getModule($moduleId);

        if ($module == null) {
            throw new HttpException(500,'Could not find requested module!');
        }

        $module->disable();

        return $this->redirect(Url::to('/admin/module/list'));
    }
}
