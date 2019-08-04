<?php

namespace zikwall\easyonline\modules\community\modules\manage\controllers;

use Yii;
use yii\web\HttpException;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\modules\manage\components\Controller;
use zikwall\easyonline\modules\community\modules\manage\models\MembershipSearch;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\community\modules\manage\models\ChangeOwnerForm;

class MemberController extends Controller
{
    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        $result = parent::getAccessRules();
        $result[] = [
            'userGroup' => [Community::USERGROUP_OWNER], 'actions' => ['change-owner']
        ];
        return $result;
    }

    /**
     * Members Administration Action
     */
    public function actionIndex()
    {
        $community = $this->getCommunity();
        $searchModel = new MembershipSearch();
        $searchModel->community_id = $community->id;
        $searchModel->status = Membership::STATUS_MEMBER;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // User Group Change
        if (Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $membership = Membership::findOne(['community_id' => $community->id, 'user_id' => Yii::$app->request->post('user_id')]);
            if ($membership === null) {
                throw new HttpException(404, 'Could not find membership!');
            }

            if ($membership->load(Yii::$app->request->post()) && $membership->validate() && $membership->save()) {
                return Yii::$app->request->post();
            }
            return $membership->getErrors();
        }

        return $this->render('index', array(
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'community' => $community
        ));
    }

    /**
     * Members Administration Action
     */
    public function actionPendingInvitations()
    {
        $community = $this->getCommunity();
        $searchModel = new MembershipSearch();
        $searchModel->community_id = $community->id;
        $searchModel->status = Membership::STATUS_INVITED;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pending-invitations', array(
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'community' => $community
        ));
    }

    /**
     * Members Administration Action
     */
    public function actionPendingApprovals()
    {
        $community = $this->getCommunity();
        $searchModel = new MembershipSearch();
        $searchModel->community_id = $community->id;
        $searchModel->status = Membership::STATUS_APPLICANT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pending-approvals', array(
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'community' => $community
        ));
    }

    /**
     * User Manage Users Page, Reject Member Request Link
     */
    public function actionRejectApplicant()
    {
        $this->forcePostRequest();

        $community = $this->getCommunity();
        $userGuid = Yii::$app->request->get('userGuid');
        $user = User::findOne(['guid' => $userGuid]);

        if ($user != null) {
            $community->removeMember($user->id);
        }

        return $this->redirect($community->getUrl());
    }

    /**
     * User Manage Users Page, Approve Member Request Link
     */
    public function actionApproveApplicant()
    {
        $this->forcePostRequest();

        $community = $this->getCommunity();
        $userGuid = Yii::$app->request->get('userGuid');
        $user = User::findOne(['guid' => $userGuid]);

        if ($user != null) {
            $membership = $community->getMembership($user->id);
            if ($membership != null && $membership->status == Membership::STATUS_APPLICANT) {
                $community->addMember($user->id);
            }
        }

        return $this->redirect($community->getUrl());
    }

    /**
     * Removes a Member
     */
    public function actionRemove()
    {
        $this->forcePostRequest();

        $community = $this->getCommunity();
        $userGuid = Yii::$app->request->get('userGuid');
        $user = User::findOne(array('guid' => $userGuid));

        if ($community->isCommunityOwner($user->id)) {
            throw new HttpException(500, 'Owner cannot be removed!');
        }

        $community->removeMember($user->id);

        // Redirect  back to Administration page
        return $this->htmlRedirect($community->createUrl('/community/manage/member'));
    }

    /**
     * Change owner
     */
    public function actionChangeOwner()
    {
        $community = $this->getCommunity();

        $model = new ChangeOwnerForm([
            'community' => $community,
            'ownerId' => $community->getCommunityOwner()->id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $community->setCommunityOwner($model->ownerId);

            return $this->redirect($community->getUrl());
        }

        return $this->render('change-owner', [
                    'community' => $community,
                    'model' => $model
        ]);
    }

}
