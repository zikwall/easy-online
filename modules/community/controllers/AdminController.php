<?php

namespace zikwall\easyonline\modules\community\controllers;

use zikwall\easyonline\modules\community\models\CommunitySearch;
use zikwall\easyonline\modules\community\models\forms\CommunitySettingsForm;
use zikwall\easyonline\modules\community\permissions\ManageCommunity;
use zikwall\easyonline\modules\content\models\Content;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\permissions\CreatePublicCommunity;
use Yii;
use zikwall\easyonline\modules\admin\components\Controller;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use yii\web\HttpException;

class AdminController extends Controller
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
        $this->subLayout = '@community/views/layouts/main';
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Communitys'));

        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => [
                ManageCommunity::class,
                ManageSettings::class
            ]],
        ];
    }

    /**
     * Shows all available communitys
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can(new ManageCommunity())) {
            $searchModel = new CommunitySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        } else if (Yii::$app->user->can(new ManageSettings())) {
            return $this->redirect([
                'settings'
            ]);
        }

        throw new HttpException(403);
    }

    /**
     * General Community Settings
     */
    public function actionSettings()
    {
        $form = new CommunitySettingsForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            $this->view->saved();
        }

        $visibilityOptions = [];

        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess')) {
            $visibilityOptions[Community::VISIBILITY_ALL] = Yii::t('CommunityModule.base', 'Public (Members & Guests)');
        }

        $visibilityOptions[Community::VISIBILITY_REGISTERED_ONLY] = Yii::t('CommunityModule.base', 'Public (Members only)');
        $visibilityOptions[Community::VISIBILITY_NONE] = Yii::t('CommunityModule.base', 'Private (Invisible)');

        $joinPolicyOptions = [
            Community::JOIN_POLICY_NONE => Yii::t('CommunityModule.base', 'Only by invite'),
            Community::JOIN_POLICY_APPLICATION => Yii::t('CommunityModule.base', 'Invite and request'),
            Community::JOIN_POLICY_FREE => Yii::t('CommunityModule.base', 'Everyone can enter')
        ];

        $contentVisibilityOptions = [
            Content::VISIBILITY_PRIVATE => Yii::t('CommunityModule.base', 'Private'),
            Content::VISIBILITY_PUBLIC => Yii::t('CommunityModule.base', 'Public')];

        return $this->render('settings', [
                'model' => $form,
                'joinPolicyOptions' => $joinPolicyOptions,
                'visibilityOptions' => $visibilityOptions,
                'contentVisibilityOptions' => $contentVisibilityOptions
            ]
        );
    }

}
