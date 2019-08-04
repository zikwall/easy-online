<?php

namespace zikwall\easyonline\modules\community\models;

use Yii;
use zikwall\easyonline\modules\user\components\ActiveQueryUser;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\models\Community;

/**
 * This is the model class for table "community_membership".
 *
 * @property integer $community_id
 * @property integer $user_id
 * @property string $originator_user_id
 * @property integer $status
 * @property string $request_message
 * @property string $last_visit
 * @property integer $show_at_dashboard
 * @property integer $can_cancel_membership
 * @property string $group_id
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $send_notifications
 *
 * @property Community $community
 */
class Membership extends \yii\db\ActiveRecord
{
    /**
     * @event \zikwall\easyonline\modules\community\MemberEvent
     */
    const EVENT_MEMBER_REMOVED = 'memberRemoved';

    /**
     * @event \zikwall\easyonline\modules\community\MemberEvent
     */
    const EVENT_MEMBER_ADDED = 'memberAdded';

    /**
     * Status Codes
     */
    const STATUS_INVITED = 1;
    const STATUS_APPLICANT = 2;
    const STATUS_MEMBER = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%community_membership}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id', 'user_id'], 'required'],
            [['community_id', 'user_id', 'originator_user_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['request_message'], 'string'],
            [['last_visit', 'created_at', 'group_id', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'community_id' => 'Community ID',
            'user_id' => 'User ID',
            'originator_user_id' => Yii::t('CommunityModule.models_Membership', 'Originator User ID'),
            'status' => Yii::t('CommunityModule.models_Membership', 'Status'),
            'request_message' => Yii::t('CommunityModule.models_Membership', 'Request Message'),
            'last_visit' => Yii::t('CommunityModule.models_Membership', 'Last Visit'),
            'created_at' => Yii::t('CommunityModule.models_Membership', 'Created At'),
            'created_by' => Yii::t('CommunityModule.models_Membership', 'Created By'),
            'updated_at' => Yii::t('CommunityModule.models_Membership', 'Updated At'),
            'updated_by' => Yii::t('CommunityModule.models_Membership', 'Updated By'),
            'can_leave' => 'Can Leave',
        ];
    }

    /**
     * Determines if this membership is a full accepted membership.
     *
     * @since v1.2.1
     * @return bool
     */
    public function isMember()
    {
        return $this->status == self::STATUS_MEMBER;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOriginator()
    {
        return $this->hasOne(User::class, ['id' => 'originator_user_id']);
    }

    public function getCommunity()
    {
        return $this->hasOne(Community::class, ['id' => 'community_id']);
    }

    public function beforeSave($insert)
    {
        Yii::$app->cache->delete('userCommunitys_' . $this->user_id);
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        Yii::$app->cache->delete('userCommunitys_' . $this->user_id);
        return parent::beforeDelete();
    }

    /**
     * Update last visit
     */
    public function updateLastVisit()
    {
        $this->last_visit = new \yii\db\Expression('NOW()');
        $this->update(false, ['last_visit']);
    }

    /**
     * Counts all new Items for this membership
     */
    public function countNewItems()
    {
        $query = \zikwall\easyonline\modules\content\models\Content::find();
        $query->where(['stream_channel' => 'default']);
        $query->andWhere(['contentcontainer_id' => $this->community->contentContainerRecord->id]);
        $query->andWhere(['>', 'created_at', $this->last_visit]);
        return $query->count();
    }

    /**
     * @param string $userId
     * @return array|bool|mixed
     */
    public static function getUserCommunities($userId = "")
    {
        if ($userId == "")
            $userId = Yii::$app->user->id;

        $cacheId = "userCommunitys_" . $userId;

        $communitys = Yii::$app->cache->get($cacheId);

        if ($communitys === false) {

            $orderSetting = Yii::$app->getModule('community')->settings->get('communityOrder');
            $orderBy = 'name ASC';
            if ($orderSetting != 0) {
                $orderBy = 'last_visit DESC';
            }

            $memberships = self::find()->joinWith('community')->where([
                'user_id' => $userId,
                Membership::tableName().'.status' => self::STATUS_MEMBER
            ])->orderBy($orderBy);

            $communitys = [];
            foreach ($memberships->all() as $membership) {
                $communitys[] = $membership->community;
            }
            Yii::$app->cache->set($cacheId, $communitys);
        }

        return $communitys;
    }

    /**
     * Returns Community for user community membership
     *
     * @since 1.0
     * @param \zikwall\easyonline\modules\user\models\User $user
     * @param boolean $memberOnly include only member status - no pending/invite states
     * @param boolean $withNotificationsOnly include only memberships with sendNotification setting
     * @return \yii\db\ActiveQuery for community model
     */
    public static function getUserCommunityQuery(User $user, $memberOnly = true, $withNotifications = null)
    {
        $query = Community::find();
        $query->leftJoin('community_membership', 'community_membership.community_id=community.id and community_membership.user_id=:userId', [':userId' => $user->id]);

        if ($memberOnly) {
            $query->andWhere(['community_membership.status' => self::STATUS_MEMBER]);
        }

        if ($withNotifications === true) {
            $query->andWhere(['community_membership.send_notifications' => 1]);
        } else if ($withNotifications === false) {
            $query->andWhere(['community_membership.send_notifications' => 0]);
        }

        if (Yii::$app->getModule('community')->settings->get('communityOrder') == 0) {
            $query->orderBy('name ASC');
        } else {
            $query->orderBy('last_visit DESC');
        }

        $query->orderBy(['name' => SORT_ASC]);

        return $query;
    }

    /**
     * Returns an ActiveQuery selcting all memberships for the given $user.
     *  
     * @param User $user
     * @param integer $membershipSatus the status of the Community by default self::STATUS_MEMBER.
     * @param integer $communityStatus the status of the Community by default Community::STATUS_ENABLED.
     * @return \yii\db\ActiveQuery
     * @since 1.2
     */
    public static function findByUser(User $user = null, $membershipSatus = self::STATUS_MEMBER, $communityStatus = Community::STATUS_ENABLED)
    {
        if (!$user) {
            $user = Yii::$app->user->getIdentity();
        }
        
        $query = Membership::find();

        if (Yii::$app->getModule('community')->settings->get('communityOrder') == 0) {
            $query->orderBy('community.name ASC');
        } else {
            $query->orderBy('community_membership.last_visit DESC');
        }

        $query->joinWith('community')->where(['community_membership.user_id' => $user->id]);
        
        if ($communityStatus) {
            $query->andWhere(['community.status' => $communityStatus]);
        }

        if ($membershipSatus) {
            $query->andWhere(['community_membership.status' => $membershipSatus]);
        }

        return $query;
    }

    /**
     * @param \zikwall\easyonline\modules\community\models\Community $community
     * @param bool $membersOnly
     * @param null $withNotifications
     * @return ActiveQueryUser
     */
    public static function getCommunityMembersQuery(Community $community, $membersOnly = true, $withNotifications = null)
    {
        $query = User::find()->active();
        $query->join('LEFT JOIN', 'community_membership', 'community_membership.user_id=user.id');

        if ($membersOnly) {
            $query->andWhere(['community_membership.status' => self::STATUS_MEMBER]);
        }

        if ($withNotifications === true) {
            $query->andWhere(['community_membership.send_notifications' => 1]);
        } else if ($withNotifications === false) {
            $query->andWhere(['community_membership.send_notifications' => 0]);
        }

        $query->andWhere(['community_id' => $community->id])->defaultOrder();
        return $query;
    }

}
