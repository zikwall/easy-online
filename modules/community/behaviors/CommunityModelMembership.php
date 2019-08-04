<?php



namespace zikwall\easyonline\modules\community\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Exception;
use yii\validators\EmailValidator;;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\user\models\Invite;
use zikwall\easyonline\modules\community\notifications\Invite as InviteNotification;
use zikwall\easyonline\modules\community\permissions\ManageCommunity;
use zikwall\easyonline\modules\community\notifications\ApprovalRequestAccepted;
use zikwall\easyonline\modules\community\notifications\ApprovalRequestDeclined;
use zikwall\easyonline\modules\community\notifications\ApprovalRequest;
use zikwall\easyonline\modules\community\notifications\InviteAccepted;
use zikwall\easyonline\modules\community\notifications\InviteDeclined;
use zikwall\easyonline\modules\community\MemberEvent;
use zikwall\easyonline\modules\community\activities\MemberAdded;
use zikwall\easyonline\modules\community\activities\MemberRemoved;

/**
 * CommunityModelMemberBehavior bundles all membership related methods of the Community model.
 *
 * @author Lucas Bartholemy <lucas@bartholemy.com>
 */
class CommunityModelMembership extends Behavior
{

    private $_communityOwner = null;

    /**
     * Checks if given Userid is Member of this Community.
     *
     * @param integer $userId
     * @return boolean
     */
    public function isMember($userId = '')
    {

        // Take current userid if none is given
        if ($userId == '' && !Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->id;
        } elseif ($userId == '' && Yii::$app->user->isGuest) {
            return false;
        }

        $membership = $this->getMembership($userId);

        if ($membership != null && $membership->status == Membership::STATUS_MEMBER) {
            return true;
        }

        return false;
    }

    /**
     * Checks if a given Userid is allowed to leave this community.
     * A User is allowed to leave, if the can_cancel_membership flag in the community_membership table is 1. If it is 2, the decision is delegated to the community.
     * 
     * @param number $userId, if empty hte currently logged in user is taken.
     * @return bool
     */
    public function canLeave($userId = '')
    {

        // Take current userid if none is given
        if ($userId == '') {
            $userId = Yii::$app->user->id;
        }

        $membership = $this->getMembership($userId);

        if ($membership != null && !empty($membership->can_cancel_membership)) {
            return $membership->can_cancel_membership === 1 || ($membership->can_cancel_membership === 2 && !empty($this->owner->members_can_leave));
        }

        return false;
    }

    /**
     * Checks if given Userid is Admin of this Community or has the permission to manage communitys.
     *
     * If no UserId is given, current UserId will be used
     *
     * @param User|integer|null $user User instance or userId
     * @return boolean
     */
    public function isAdmin($user = null)
    {
        $userId = ($user instanceof User) ? $user->id : $user;

        if (empty($userId) && Yii::$app->user->can(new ManageCommunity())) {
            return true;
        }

        if (!$userId) {
            $userId = Yii::$app->user->id;
        }

        if ($this->isCommunityOwner($userId)) {
            return true;
        }

        $membership = $this->getMembership($userId);

        return ($membership && $membership->group_id == Community::USERGROUP_ADMIN && $membership->status == Membership::STATUS_MEMBER);
    }

    /**
     * Sets Owner for this workcommunity
     *
     * @param User|integer|null $userId
     * @return boolean
     */
    public function setCommunityOwner($user = null)
    {
        $userId = ($user instanceof User) ? $user->id : $user;

        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == 0) {
            $userId = Yii::$app->user->id;
        }

        $this->setAdmin($userId);

        $this->owner->created_by = $userId;
        $this->owner->update(false, ['created_by']);

        $this->_communityOwner = null;

        return true;
    }

    /**
     * Gets Owner for this workcommunity
     *
     * @return User
     */
    public function getCommunityOwner()
    {
        if ($this->_communityOwner != null) {
            return $this->_communityOwner;
        }

        $this->_communityOwner = User::findOne(['id' => $this->owner->created_by]);

        return $this->_communityOwner;
    }

    /**
     * Is given User owner of this Community
     * @param User|int|null $userId
     * @return bool
     */
    public function isCommunityOwner($userId = null)
    {
        if (empty($userId) && Yii::$app->user->isGuest) {
            return false;
        } else if ($userId instanceof User) {
            $userId = $userId->id;
        }  else if (empty($userId)) {
            $userId = Yii::$app->user->id;
        }

        return $this->owner->created_by == $userId;
    }

    /**
     * Sets Owner for this workcommunity
     *
     * @param integer $userId
     * @return boolean
     */
    public function setAdmin($userId = null)
    {
        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == 0) {
            $userId = Yii::$app->user->id;
        }

        $membership = $this->getMembership($userId);
        if ($membership != null) {
            $membership->group_id = Community::USERGROUP_ADMIN;
            $membership->save();
            return true;
        }

        return false;
    }

    /**
     * Returns the CommunityMembership Record for this Community
     *
     * If none Record is found, null is given
     */
    public function getMembership($userId = null)
    {
        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == "") {
            $userId = Yii::$app->user->id;
        }

        return Membership::findOne(['user_id' => $userId, 'community_id' => $this->owner->id]);
    }

    /**
     * Invites a not registered member to this community
     *
     * @param string $email
     * @param integer $originatorUserId
     */
    public function inviteMemberByEMail($email, $originatorUserId)
    {

        // Invalid E-Mail
        $validator = new EmailValidator;
        if (!$validator->validate($email))
            return false;

        // User already registered
        $user = User::findOne(['email' => $email]);
        if ($user != null)
            return false;

        $userInvite = Invite::findOne(['email' => $email]);
        // No invite yet
        if ($userInvite == null) {
            // Invite EXTERNAL user
            $userInvite = new Invite();
            $userInvite->email = $email;
            $userInvite->source = Invite::SOURCE_INVITE;
            $userInvite->user_originator_id = $originatorUserId;
            $userInvite->community_invite_id = $this->owner->id;
            // There is a pending registration
            // Steal it und send mail again
            // Unfortunately there a no multiple workcommunity invites supported
            // so we take the last one
        } else {
            $userInvite->user_originator_id = $originatorUserId;
            $userInvite->community_invite_id = $this->owner->id;
        }

        if ($userInvite->validate() && $userInvite->save()) {
            $userInvite->sendInviteMail();
            return true;
        }

        return false;
    }

    /**
     * Requests Membership
     *
     * @param integer $userId
     * @param string $message
     */
    public function requestMembership($userId, $message = '')
    {

        $user = ($userId instanceof User) ? $userId : User::findOne(['id' => $userId]);

        // Add Membership
        $membership = new Membership([
            'community_id' => $this->owner->id,
            'user_id' => $user->id,
            'status' => Membership::STATUS_APPLICANT,
            'group_id' => Community::USERGROUP_MEMBER,
            'request_message' => $message
        ]);

        $membership->save();

        ApprovalRequest::instance()
                ->from($user)->about($this->owner)->withMessage($message)->sendBulk($this->getAdmins());
    }

    /**
     * Returns the Admins of this Community
     */
    public function getAdmins()
    {
        $admins = [];
        $adminMemberships = Membership::findAll(['community_id' => $this->owner->id, 'group_id' => Community::USERGROUP_ADMIN]);

        foreach ($adminMemberships as $admin) {
            $admins[] = $admin->user;
        }

        return $admins;
    }

    /**
     * Invites a registered user to this community
     *
     * If user is already invited, retrigger invitation.
     * If user is applicant approve it.
     *
     * @param integer $userId
     * @param integer $originatorId
     */
    public function inviteMember($userId, $originatorId)
    {
        $membership = $this->getMembership($userId);

        if ($membership != null) {
            switch ($membership->status) {
                case Membership::STATUS_APPLICANT:
                    // If user is an applicant of this community add user and return.
                    $this->addMember(Yii::$app->user->id);
                case Membership::STATUS_MEMBER:
                    // If user is already a member just ignore the invitation. 
                    return;
                case Membership::STATUS_INVITED:
                    // If user is already invited, remove old invite notification and retrigger
                    $oldNotification = new InviteNotification(['source' => $this->owner]);
                    $oldNotification->delete(User::findOne(['id' => $userId]));
                    break;
            }
        } else {
            $membership = new Membership([
                'community_id' => $this->owner->id,
                'user_id' => $userId,
                'status' => Membership::STATUS_INVITED,
                'group_id' => Community::USERGROUP_MEMBER
            ]);
        }

        // Update or set originator 
        $membership->originator_user_id = $originatorId;

        if ($membership->save()) {
            $this->sendInviteNotification($userId, $originatorId);
        } else {
            throw new Exception('Could not save membership!' . print_r($membership->getErrors(), 1));
        }
    }

    /**
     * Sends an Invite Notification to the given user.
     * 
     * @param integer $userId
     * @param integer $originatorId
     */
    protected function sendInviteNotification($userId, $originatorId)
    {
        $notification = new InviteNotification([
            'source' => $this->owner,
            'originator' => User::findOne(['id' => $originatorId])
        ]);

        $notification->send(User::findOne(['id' => $userId]));
    }

    /**
     * Adds an member to this community.
     *
     * This can happens after an clicking "Request Membership" Link
     * after Approval or accepting an invite.
     *
     * @param integer $userId
     * @param integer $canLeave 0: user cannot cancel membership | 1: can cancel membership | 2: depending on community flag members_can_leave
     */
    public function addMember($userId, $canLeave = 1)
    {
        $user = User::findOne(['id' => $userId]);
        $membership = $this->getMembership($userId);

        if ($membership == null) {
            // Add Membership
            $membership = new Membership([
                'community_id' => $this->owner->id,
                'user_id' => $userId,
                'status' => Membership::STATUS_MEMBER,
                'group_id' => Community::USERGROUP_MEMBER,
                'can_cancel_membership' => $canLeave
            ]);

            $userInvite = Invite::findOne(['email' => $user->email]);

            if ($userInvite !== null && $userInvite->source == Invite::SOURCE_INVITE) {
                InviteAccepted::instance()->from($user)->about($this->owner)
                        ->send(User::findOne(['id' => $userInvite->user_originator_id]));
            }
        } else {

            // User is already member
            if ($membership->status == Membership::STATUS_MEMBER) {
                return true;
            }

            // User requested membership
            if ($membership->status == Membership::STATUS_APPLICANT) {
                ApprovalRequestAccepted::instance()
                        ->from(Yii::$app->user->getIdentity())->about($this->owner)->send($user);
            }

            // User was invited
            if ($membership->status == Membership::STATUS_INVITED) {
                InviteAccepted::instance()->from($user)->about($this->owner)
                        ->send(User::findOne(['id' => $membership->originator_user_id]));
            }

            // Update Membership
            $membership->status = Membership::STATUS_MEMBER;
        }

        $membership->save();

        MemberEvent::trigger(Membership::class, Membership::EVENT_MEMBER_ADDED, new MemberEvent([
            'community' => $this->owner, 'user' => $user
        ]));
        
        
        // Create Activity
        MemberAdded::instance()->from($user)->about($this->owner)->save();

        // Members can't also follow the community
        $this->owner->unfollow($userId);

        // Delete invite notification for this user
        InviteNotification::instance()->about($this->owner)->delete($user);

        // Delete pending approval request notifications for this user
        ApprovalRequest::instance()->from($user)->about($this->owner)->delete();
    }

    /**
     * Remove Membership
     *
     * @param $userId UserId of User to Remove
     */
    public function removeMember($userId = "")
    {
        if ($userId == "") {
            $userId = Yii::$app->user->id;
        }

        $user = User::findOne(['id' => $userId]);

        $membership = $this->getMembership($userId);

        if ($this->isCommunityOwner($userId)) {
            return false;
        }

        if ($membership == null) {
            return true;
        }

        // If was member, create a activity for that
        if ($membership->status == Membership::STATUS_MEMBER) {
            $activity = new MemberRemoved();
            $activity->source = $this->owner;
            $activity->originator = $user;
            $activity->create();

            MemberEvent::trigger(Membership::class, Membership::EVENT_MEMBER_REMOVED, new MemberEvent([
                'community' => $this->owner, 'user' => $user
            ]));
        } elseif ($membership->status == Membership::STATUS_INVITED && $membership->originator !== null) {
            // Was invited, but declined the request - inform originator
            InviteDeclined::instance()
                ->from($user)->about($this->owner)->send($membership->originator);
        } elseif ($membership->status == Membership::STATUS_APPLICANT) {
            ApprovalRequestDeclined::instance()
                    ->from(Yii::$app->user->getIdentity())->about($this->owner)->send($user);
        }

        foreach (Membership::findAll(['user_id' => $userId, 'community_id' => $this->owner->id]) as $membership) {
            $membership->delete();
        }

        ApprovalRequest::instance()->from($user)->about($this->owner)->delete();

        InviteNotification::instance()->from($this->owner)->delete($user);
    }

}
