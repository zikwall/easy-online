<?php

namespace zikwall\easyonline\modules\admin\controllers;

use zikwall\easyonline\modules\ {
    admin\models\forms\BasicSettingsForm,
    admin\models\forms\DesignSettingsForm,
    core\helpers\ThemeHelper
};

use Yii;

class SettingController extends \zikwall\easyonline\modules\admin\components\Controller
{
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->subLayout = '@admin/views/layouts/setting';

        return parent::init();
    }

    public function actionIndex()
    {
        return $this->redirect(['basic']);
    }

    public function actionBasic()
    {
        $form = new BasicSettingsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
            return $this->redirect(['/admin/setting/basic']);
        }
        return $this->render('basic', [
            'model' => $form
        ]);
    }

    public function actionDesign()
    {
        $form = new DesignSettingsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
            return $this->redirect([
                '/admin/setting/design'
            ]);
        }

        $themes = [];
        foreach (ThemeHelper::getThemes() as $theme) {
            $themes[$theme->name] = $theme->name;
        }

        return $this->render('design', [
            'model' => $form,
            'themes' => $themes,
        ]);
    }

}
