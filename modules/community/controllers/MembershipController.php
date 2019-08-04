<?php

namespace zikwall\easyonline\modules\community\controllers;

use Yii;
use yii\web\HttpException;
use zikwall\easyonline\modules\core\widgets\ModalClose;
use zikwall\easyonline\modules\user\models\UserPicker;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\community\models\forms\RequestMembershipForm;
use zikwall\easyonline\modules\user\widgets\UserListBox;
use zikwall\easyonline\modules\core\behaviors\AccessControl;

class MembershipController extends \zikwall\easyonline\modules\content\components\ContentContainerController
{
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

    /**
     * Provides a searchable user list of all workcommunity members in json.
     *
     */
    public function actionSearch()
    {
        Yii::$app->response->format = 'json';

        $community = $this->getCommunity();
        $visibility = (int)$community->visibility;
        if ($visibility === Community::VISIBILITY_NONE && !$community->isMember() ||
            ($visibility === Community::VISIBILITY_REGISTERED_ONLY && Yii::$app->user->isGuest)
        ) {
            throw new HttpException(404, Yii::t('CommunityModule.controllers_CommunityController', 'This action is only available for workcommunity members!'));
        }

        return UserPicker::filter([
            'query' => $community->getMembershipUser(),
            'keyword' => Yii::$app->request->get('keyword'),
            'fillUser' => true,
            'disabledText' => Yii::t('CommunityModule.controllers_CommunityController', 'This user is not a member of this community.')
        ]);
    }

    /**
     * Provides a searchable user list of all workcommunity members in json.
     *
     */
    public function actionSearchInvite()
    {
        Yii::$app->response->format = 'json';

        $community = $this->getCommunity();

        if (!$community->isMember()) {
            throw new HttpException(404, Yii::t('CommunityModule.controllers_CommunityController', 'This action is only available for workcommunity members!'));
        }

        return UserPicker::filter([
            'query' => $community->getNonMembershipUser(),
            'keyword' => Yii::$app->request->get('keyword'),
            'fillUser' => true,
            'disabledText' => Yii::t('CommunityModule.controllers_CommunityController', 'This user is already a member of this community.')
        ]);
    }

    /**
     * Requests Membership for this Community
     */
    public function actionRequestMembership()
    {
        $this->forcePostRequest();
        $community = $this->getCommunity();

        if (!$community->canJoin(Yii::$app->user->id))
            throw new HttpException(500, Yii::t('CommunityModule.controllers_CommunityController', 'You are not allowed to join this community!'));

        if ($community->join_policy == Community::JOIN_POLICY_APPLICATION) {
            // Redirect to Membership Request Form
            return $this->redirect($this->createUrl('//community/community/requestMembershipForm', ['sguid' => $this->getCommunity()->guid]));
        }

        $community->addMember(Yii::$app->user->id);
        return $this->htmlRedirect($community->getUrl());
    }

    /**
     * Requests Membership Form for this Community
     * (If a message is required.)
     *
     */
    public function actionRequestMembershipForm()
    {
        $community = $this->getCommunity();

        // Check if we have already some sort of membership
        if (Yii::$app->user->isGuest || $community->getMembership(Yii::$app->user->id) != null) {
            throw new HttpException(500, Yii::t('CommunityModule.controllers_CommunityController', 'Could not request membership!'));
        }

        $model = new RequestMembershipForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $community->requestMembership(Yii::$app->user->id, $model->message);
            return $this->renderAjax('requestMembershipSave', ['community' => $community]);
        }

        return $this->renderAjax('requestMembership', ['model' => $model, 'community' => $community]);
    }

    public function actionRevokeNotifications()
    {
        $community = $this->getCommunity();
        Yii::$app->notification->setCommunitySetting(Yii::$app->user->getIdentity(), $community, false);
        return $this->redirect($community->getUrl());
    }

    public function actionReceiveNotifications()
    {
        $community = $this->getCommunity();
        Yii::$app->notification->setCommunitySetting(Yii::$app->user->getIdentity(), $community, true);
        return $this->redirect($community->getUrl());
    }

    /**
     * Revokes Membership for this workcommunity
     */
    public function actionRevokeMembership()
    {
        $this->forcePostRequest();
        $community = $this->getCommunity();

        if ($community->isCommunityOwner()) {
            throw new HttpException(500, Yii::t('CommunityModule.controllers_CommunityController', 'As owner you cannot revoke your membership!'));
        } elseif (!$community->canLeave()) {
            throw new HttpException(500, Yii::t('CommunityModule.controllers_CommunityController', 'Sorry, you are not allowed to leave this community!'));
        }

        $community->removeMember();

        return $this->goHome();
    }

    /**
     * Invite New Members to this workcommunity
     */
    public function actionInvite()
    {
        $community = $this->getCommunity();

        // Check Permissions to Invite
        if (!$community->canInvite()) {
            throw new HttpException(403, Yii::t('CommunityModule.controllers_MembershipController', 'Access denied - You cannot invite members!'));
        }

        $model = new \zikwall\easyonline\modules\community\models\forms\InviteForm();
        $model->community = $community;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $statusInvite = false;

            // Invite existing members
            foreach ($model->getInvites() as $user) {
                $community->inviteMember($user->id, Yii::$app->user->id);
                $statusInvite = $community->getMembership($user->id)->status;
            }

            // Invite non existing members
            if (Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite')) {
                foreach ($model->getInvitesExternal() as $email) {
                    $statusInvite = ($community->inviteMemberByEMail($email, Yii::$app->user->id)) ? Membership::STATUS_INVITED : false;
                }
            }

            switch ($statusInvite) {
                case Membership::STATUS_INVITED:
                    return ModalClose::widget(['success' => Yii::t('CommunityModule.views_community_statusInvite', 'User has been invited.')]);
                case Membership::STATUS_MEMBER:
                    return ModalClose::widget(['success' => Yii::t('CommunityModule.views_community_statusInvite', 'User has become a member.')]);
                default:
                    return ModalClose::widget(['warn' => Yii::t('CommunityModule.views_community_statusInvite', 'User has not been invited.')]);
            }
        }

        return $this->renderAjax('invite', array('model' => $model, 'community' => $community));
    }

    /**
     * When a user clicks on the Accept Invite Link, this action is called.
     * After this the user should be member of this workcommunity.
     */
    public function actionInviteAccept()
    {

        $this->forcePostRequest();
        $community = $this->getCommunity();

        // Load Pending Membership
        $membership = $community->getMembership();
        if ($membership == null) {
            throw new HttpException(404, Yii::t('CommunityModule.controllers_CommunityController', 'There is no pending invite!'));
        }

        // Check there are really an Invite
        if ($membership->status == Membership::STATUS_INVITED) {
            $community->addMember(Yii::$app->user->id);
        }

        return $this->redirect($community->getUrl());
    }

    /**
     * Toggle community content display at dashboard
     *
     * @throws HttpException
     */
    public function actionSwitchDashboardDisplay()
    {
        $this->forcePostRequest();
        $community = $this->getCommunity();

        // Load Pending Membership
        $membership = $community->getMembership();
        if ($membership == null) {
            throw new HttpException(404, 'Membership not found!');
        }

        if (Yii::$app->request->get('show') == 0) {
            $membership->show_at_dashboard = 0;
        } else {
            $membership->show_at_dashboard = 1;
        }
        $membership->save();

        return $this->redirect($community->getUrl());
    }

    /**
     * Returns an user list which are community members
     */
    public function actionMembersList()
    {
        $title = Yii::t('CommunityModule.controllers_MembershipController', "<strong>Members</strong>");

        return $this->renderAjaxContent(UserListBox::widget([
                            'query' => Membership::getCommunityMembersQuery($this->getCommunity())->visible(),
                            'title' => $title
        ]));
    }

}

?>
