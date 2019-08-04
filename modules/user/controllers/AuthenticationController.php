<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\user\models\forms\AuthenticationSettingsForm;
use zikwall\easyonline\modules\user\models\Group;

class AuthenticationController extends \zikwall\easyonline\modules\admin\components\Controller
{
    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setActionTitles([
            'basic' => Yii::t('AdminModule.base', 'Basic'),
            'authentication' => Yii::t('AdminModule.base', 'Authentication'),
            'authentication-ldap' => Yii::t('AdminModule.base', 'Authentication')
        ]);

        $this->subLayout = '@user/views/layouts/admin';
        
		return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => ManageSettings::class]
        ];
    }

    /**
     * Returns a List of Users
     */
    public function actionIndex()
    {
        $form = new AuthenticationSettingsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
        }

        // Build Group Dropdown
        $groups = [];
        $groups[''] = Yii::t('AdminModule.controllers_SettingController', 'None - shows dropdown in user registration.');
        foreach (Group::find()->all() as $group) {
            if (!$group->is_admin_group) {
                $groups[$group->id] = $group->name;
            }
        }

        return $this->render('authentication', [
			'model' => $form,
			'groups' => $groups
		]);
    }
}
