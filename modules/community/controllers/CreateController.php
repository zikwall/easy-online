<?php

namespace zikwall\easyonline\modules\community\controllers;

use Yii;
use yii\web\HttpException;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\permissions\CreatePublicCommunity;
use zikwall\easyonline\modules\community\permissions\CreatePrivateCommunity;
use zikwall\easyonline\modules\core\behaviors\AccessControl;
use zikwall\easyonline\modules\ui\widgets\ContentModalDialog;

class CreateController extends Controller
{

    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->redirect(['create']);
    }

    /**
     * Creates a new Community
     */
    public function actionCreate($visibility = null, $skip = 0)
    {
        // User cannot create communitys (public or private)
        if (!Yii::$app->user->permissionmanager->can(new CreatePublicCommunity) && !Yii::$app->user->permissionmanager->can(new CreatePrivateCommunity)) {
            throw new HttpException(400, 'You are not allowed to create communitys!');
        }

        $model = $this->createCommunityModel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($skip) {
                return $this->htmlRedirect($model->getUrl());
            }
            return $this->actionModules($model->id);
        }

        $visibilityOptions = [];
        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') && Yii::$app->user->permissionmanager->can(new CreatePublicCommunity)) {
            $visibilityOptions[Community::VISIBILITY_ALL] = Yii::t('CommunityModule.base', 'Public (Members & Guests)');
        }
        if (Yii::$app->user->permissionmanager->can(new CreatePublicCommunity)) {
            $visibilityOptions[Community::VISIBILITY_REGISTERED_ONLY] = Yii::t('CommunityModule.base', 'Public (Members only)');
        }
        if (Yii::$app->user->permissionmanager->can(new CreatePrivateCommunity)) {
            $visibilityOptions[Community::VISIBILITY_NONE] = Yii::t('CommunityModule.base', 'Private (Invisible)');
        }

        // allow setting pre-selected visibility
        if ($visibility !== null && isset($visibilityOptions[$visibility])) {
            $model->visibility = $visibility;
        }

        $joinPolicyOptions = [
            Community::JOIN_POLICY_NONE => Yii::t('CommunityModule.base', 'Only by invite'),
            Community::JOIN_POLICY_APPLICATION => Yii::t('CommunityModule.base', 'Invite and request'),
            Community::JOIN_POLICY_FREE => Yii::t('CommunityModule.base', 'Everyone can enter')
        ];

        return ContentModalDialog::widget([
            'content' =>  $this->renderAjax('create', ['model' => $model, 'visibilityOptions' => $visibilityOptions, 'joinPolicyOptions' => $joinPolicyOptions]),
            'title' => Yii::t('CommunityModule.views_create_create', '<strong>Create</strong> new community')
        ]);
    }

    /**
     * Activate / deactivate modules
     */
    public function actionModules($community_id)
    {
        $community = Community::find()->where(['id' => $community_id])->one();

        if (count($community->getAvailableModules()) == 0) {
            return $this->actionInvite($community);
        } else {
            return $this->renderAjax('modules', ['community' => $community, 'availableModules' => $community->getAvailableModules()]);
        }
    }

    /**
     * Invite user
     */
    public function actionInvite($community = null)
    {
        $community = ($community == null) ? Community::findOne(['id' => Yii::$app->request->get('communityId', "")]) : $community;

        $model = new \zikwall\easyonline\modules\community\models\forms\InviteForm();
        $model->community = $community;

        $canInviteExternal = Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // Invite existing members
            foreach ($model->getInvites() as $user) {
                $community->inviteMember($user->id, Yii::$app->user->id);
            }
            // Invite non existing members
            if ($canInviteExternal) {
                foreach ($model->getInvitesExternal() as $email) {
                    $community->inviteMemberByEMail($email, Yii::$app->user->id);
                }
            }

            return $this->htmlRedirect($community->getUrl());
        }

        return $this->renderAjax('invite', [
                    'canInviteExternal' => $canInviteExternal,
                    'model' => $model,
                    'community' => $community
        ]);
    }

    /**
     * Creates an empty community model
     *
     * @return Community
     */
    protected function createCommunityModel()
    {
        $model = new Community();
        $model->scenario = 'create';
        $model->visibility = Yii::$app->getModule('community')->settings->get('defaultVisibility', Community::VISIBILITY_REGISTERED_ONLY);
        $model->join_policy = Yii::$app->getModule('community')->settings->get('defaultJoinPolicy', Community::JOIN_POLICY_APPLICATION);
        return $model;
    }

}

?>
