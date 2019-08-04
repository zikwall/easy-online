<?php

namespace zikwall\easyonline\modules\admin\controllers;

use Yii;
use zikwall\easyonline\modules\admin\widgets\AdminMenu;

class IndexController extends \zikwall\easyonline\modules\admin\components\Controller
{
    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => Yii::$app->getModule('admin')->getPermissions()]
        ];
    }

    public function actionIndex()
    {
        $adminMenu = new AdminMenu();

		return $this->redirect($adminMenu->items[0]['url']);
    }

}
