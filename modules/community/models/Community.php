<?php

namespace zikwall\easyonline\modules\community\models;

use Yii;
use zikwall\easyonline\modules\community\behaviors\CommunityModelMembership;
use zikwall\easyonline\modules\community\behaviors\CommunityModelModules;
use zikwall\easyonline\modules\community\permissions\CreatePrivateCommunity;
use zikwall\easyonline\modules\community\permissions\CreatePublicCommunity;
use zikwall\easyonline\modules\community\components\UrlValidator;
use zikwall\easyonline\modules\content\components\behaviors\SettingsBehavior;
use zikwall\easyonline\modules\content\models\Content;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;
use zikwall\easyonline\modules\core\behaviors\GUID;
use zikwall\easyonline\modules\user\behaviors\Followable;
use zikwall\easyonline\modules\user\models\User;
use yii\helpers\Url;

/**
 * This is the model class for table "community".
 *
 * @property integer $id
 * @property string $guid
 * @property string $name
 * @property string $description
 * @property string $url
 * @property integer $join_policy
 * @property integer $visibility
 * @property integer $status
 * @property string $tags
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $auto_add_new_members
 * @property integer $contentcontainer_id
 * @property integer $default_content_visibility
 * @property string $color
 */
class Community extends ContentContainerActiveRecord
{
    const JOIN_POLICY_NONE = 0; // No Self Join Possible
    const JOIN_POLICY_APPLICATION = 1; // Invitation and Application Possible
    const JOIN_POLICY_FREE = 2; // Free for All
    // Visibility: Who can view the community content.
    const VISIBILITY_NONE = 0; // Private: This community is invisible for non-community-members
    const VISIBILITY_REGISTERED_ONLY = 1; // Only registered users (no guests)
    const VISIBILITY_ALL = 2; // Public: All Users (Members and Guests)
    // Status
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_ARCHIVED = 2;
    // UserGroups
    const USERGROUP_OWNER = 'owner';
    const USERGROUP_ADMIN = 'admin';
    const USERGROUP_MODERATOR = 'moderator';
    const USERGROUP_MEMBER = 'member';
    const USERGROUP_USER = 'user';
    const USERGROUP_GUEST = 'guest';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['join_policy', 'visibility', 'status', 'auto_add_new_members', 'default_content_visibility'], 'integer'],
            [['name'], 'required'],
            [['description', 'tags', 'color'], 'string'],
            [['join_policy'], 'in', 'range' => [0, 1, 2]],
            [['visibility'], 'in', 'range' => [0, 1, 2]],
            [['visibility'], 'checkVisibility'],
            [['url'], 'unique', 'skipOnEmpty' => 'true'],
            [['guid', 'name', 'url'], 'string', 'max' => 45, 'min' => 2],
            [['url'], UrlValidator::class],
        ];

        if (Yii::$app->getModule('community')->useUniqueCommunityNames) {
            $rules[] = [['name'], 'unique', 'targetClass' => self::class];
        }
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['edit'] = ['name', 'color', 'description', 'tags', 'join_policy', 'visibility', 'default_content_visibility', 'url'];
        $scenarios['create'] = ['name', 'color', 'description', 'join_policy', 'visibility'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('CommunityModule.models_Community', 'Name'),
            'color' => Yii::t('CommunityModule.models_Community', 'Color'),
            'description' => Yii::t('CommunityModule.models_Community', 'Description'),
            'join_policy' => Yii::t('CommunityModule.models_Community', 'Join Policy'),
            'visibility' => Yii::t('CommunityModule.models_Community', 'Visibility'),
            'status' => Yii::t('CommunityModule.models_Community', 'Status'),
            'tags' => Yii::t('CommunityModule.models_Community', 'Tags'),
            'created_at' => Yii::t('CommunityModule.models_Community', 'Created At'),
            'created_by' => Yii::t('CommunityModule.models_Community', 'Created By'),
            'updated_at' => Yii::t('CommunityModule.models_Community', 'Updated At'),
            'updated_by' => Yii::t('CommunityModule.models_Community', 'Updated by'),
            'ownerUsernameSearch' => Yii::t('CommunityModule.models_Community', 'Owner'),
            'default_content_visibility' => Yii::t('CommunityModule.models_Community', 'Default content visibility'),
        ];
    }

    public function attributeHints()
    {
        return [
            'visibility' => Yii::t('CommunityModule.views_admin_edit', 'Choose the security level for this workcommunity to define the visibleness.'),
            'join_policy' => Yii::t('CommunityModule.views_admin_edit', 'Choose the kind of membership you want to provide for this workcommunity.'),
            'default_content_visibility' =>  Yii::t('CommunityModule.views_admin_edit', 'Choose if new content should be public or private by default')
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            GUID::class,
            SettingsBehavior::class,
            CommunityModelModules::class,
            CommunityModelMembership::class,
            Followable::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //Yii::$app->search->update($this);

        $user = \zikwall\easyonline\modules\user\models\User::findOne(['id' => $this->created_by]);

        if ($insert) {
            // Auto add creator as admin
            $membership = new Membership();
            $membership->community_id = $this->id;
            $membership->user_id = $user->id;
            $membership->status = Membership::STATUS_MEMBER;
            $membership->group_id = self::USERGROUP_ADMIN;
            $membership->save();

            /*$activity = new \zikwall\easyonline\modules\community\activities\Created;
            $activity->source = $this;
            $activity->originator = $user;
            $activity->create();*/
        }

        Yii::$app->cache->delete('userCommunitys_' . $user->id);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->url = UrlValidator::autogenerateUniqueCommunityUrl($this->name);
        }

        if ($this->url == '') {
            $this->url = new \yii\db\Expression('NULL');
        } else {
            $this->url = mb_strtolower($this->url);
        }

        if ($this->visibility == self::VISIBILITY_NONE) {
            $this->join_policy = self::JOIN_POLICY_NONE;
            $this->default_content_visibility = Content::VISIBILITY_PRIVATE;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        foreach ($this->getAvailableModules() as $moduleId => $module) {
            if ($this->isModuleEnabled($moduleId)) {
                $this->disableModule($moduleId);
            }
        }

        Yii::$app->search->delete($this);

        $this->getProfileImage()->delete();

        \zikwall\easyonline\modules\user\models\Follow::deleteAll(['object_id' => $this->id, 'object_model' => 'Community']);

        foreach (Membership::findAll(['community_id' => $this->id]) as $communityMembership) {
            $communityMembership->delete();
        }

        \zikwall\easyonline\modules\user\models\Invite::deleteAll(['community_invite_id' => $this->id]);

        // When this workcommunity is used in a group as default workcommunity, delete the link
        foreach (\zikwall\easyonline\modules\user\models\Group::findAll(['community_id' => $this->id]) as $group) {
            $group->community_id = "";
            $group->save();
        }

        return parent::beforeDelete();
    }

    /**
     * Indicates that this user can join this workcommunity
     *
     * @param $userId User Id of User
     */
    public function canJoin($userId = "")
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        // Take current userid if none is given
        if ($userId == "") {
            $userId = Yii::$app->user->id;
        }

        // Checks if User is already member
        if ($this->isMember($userId)) {
            return false;
        }

        // No one can join
        if ($this->join_policy == self::JOIN_POLICY_NONE) {
            return false;
        }

        return true;
    }

    /**
     * Indicates that this user can join this workcommunity w
     * ithout permission
     *
     * @param $userId User Id of User
     */
    public function canJoinFree($userId = "")
    {
        // Take current userid if none is given
        if ($userId == "")
            $userId = Yii::$app->user->id;

        // Checks if User is already member
        if ($this->isMember($userId))
            return false;

        // No one can join
        if ($this->join_policy == self::JOIN_POLICY_FREE)
            return true;

        return false;
    }

    /**
     * Checks if given user can invite people to this workcommunity
     * Note: use directly permission instead
     *
     * @deprecated since version 1.1
     * @return boolean
     */
    public function canInvite()
    {
        return $this->getPermissionManager()->can(new \zikwall\easyonline\modules\community\permissions\InviteUsers());
    }

    /**
     * Checks if given user can share content.
     * Shared Content is public and is visible also for non members of the community.
     * Note: use directly permission instead
     *
     * @deprecated since version 1.1
     * @return boolean
     */
    public function canShare()
    {
        return $this->getPermissionManager()->can(new \zikwall\easyonline\modules\content\permissions\CreatePublicContent());
    }

    /**
     * Returns an array of informations used by search subsystem.
     * Function is defined in interface ISearchable
     *
     * @return Array
     */
    public function getSearchAttributes()
    {
        $attributes = [
            'title' => $this->name,
            'tags' => $this->tags,
            'description' => $this->description,
        ];

        $this->trigger(self::EVENT_SEARCH_ADD, new \zikwall\easyonline\modules\search\events\SearchAddEvent($attributes));

        return $attributes;
    }

    /**
     * Returns the Search Result Output
     */
    public function getSearchResult()
    {
        return Yii::$app->getController()->widget('application.modules_core.community.widgets.CommunitySearchResultWidget', array('community' => $this), true);
    }

    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'community_type_id']);
    }

    /**
     * Checks if community has tags
     *
     * @return boolean has tags set
     */
    public function hasTags()
    {
        return ($this->tags != '');
    }

    /**
     * Returns an array with assigned Tags
     */
    public function getTags()
    {

        // split tags string into individual tags
        return preg_split("/[;,# ]+/", $this->tags);
    }

    /**
     * Archive this Community
     */
    public function archive()
    {
        $this->status = self::STATUS_ARCHIVED;
        $this->save();
    }

    /**
     * Unarchive this Community
     */
    public function unarchive()
    {
        $this->status = self::STATUS_ENABLED;
        $this->save();
    }

    /**
     * Returns wether or not a Community is archived.
     *
     * @return boolean
     * @since 1.2
     */
    public function isArchived()
    {
        return $this->status === self::STATUS_ARCHIVED;
    }

    /**
     * Creates an url in community scope.
     * (Adding sguid parameter to identify current community.)
     * See CController createUrl() for more details.
     *
     * @since 0.9
     * @param string $route the URL route.
     * @param array $params additional GET parameters.
     * @param boolean|string $scheme whether to create an absolute URL and if it is a string, the scheme (http or https) to use.
     * @return string
     */
    public function createUrl($route = null, $params = array(), $scheme = false)
    {
        if ($route == null) {
            $route = '/community/community';
        }

        array_unshift($params, $route);
        if (!isset($params['sguid'])) {
            $params['sguid'] = $this->guid;
        }

        return Url::toRoute($params, $scheme);
    }

    /**
     * Validator for visibility
     *
     * Used in edit scenario to check if the user really can create communitys
     * on this visibility.
     *
     * @param type $attribute
     * @param type $params
     */
    public function checkVisibility($attribute, $params)
    {
        $visibility = $this->$attribute;

        // Not changed
        if (!$this->isNewRecord && $visibility == $this->getOldAttribute($attribute)) {
            return;
        }
        if ($visibility == self::VISIBILITY_NONE && !Yii::$app->user->permissionManager->can(new CreatePrivateCommunity())) {
            $this->addError($attribute, Yii::t('CommunityModule.models_Community', 'You cannot create private visible communitys!'));
        }

        if (($visibility == self::VISIBILITY_REGISTERED_ONLY || $visibility == self::VISIBILITY_ALL) && !Yii::$app->user->permissionManager->can(new CreatePublicCommunity())) {
            $this->addError($attribute, Yii::t('CommunityModule.models_Community', 'You cannot create public visible communitys!'));
        }
    }

    /**
     * Returns display name (title) of community
     *
     * @since 0.11.0
     * @return string
     */
    public function getDisplayName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function canAccessPrivateContent(User $user = null)
    {
        $user = !$user && !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity() : $user;

        if (Yii::$app->getModule('community')->globalAdminCanAccessPrivateContent && $user->isSystemAdmin()) {
            return true;
        }

        return ($this->isMember($user));
    }

    /**
     * @inheritdoc
     */
    public function getWallOut()
    {
        return \zikwall\easyonline\modules\community\widgets\Wall::widget(['community' => $this]);
    }

    public function getCounter()
    {
        // cache

        return $this->counter;
    }

    public function getMemberships()
    {
        $query = $this->hasMany(Membership::class, ['community_id' => 'id']);
        $query->andWhere(['community_membership.status' => Membership::STATUS_MEMBER]);
        $query->addOrderBy(['community_membership.group_id' => SORT_DESC]);
        return $query;
    }

    public function getMembershipUser($status = null)
    {
        $status = ($status == null) ? Membership::STATUS_MEMBER : $status;
        $query = User::find();
        $query->leftJoin('community_membership', 'community_membership.user_id=user.id AND community_membership.community_id=:community_id AND community_membership.status=:member', ['community_id' => $this->id, 'member' => $status]);
        $query->andWhere('community_membership.community_id IS NOT NULL');
        $query->addOrderBy(['community_membership.group_id' => SORT_DESC]);
        return $query;
    }

    public function getNonMembershipUser()
    {
        $query = User::find();
        $query->leftJoin('community_membership', 'community_membership.user_id=user.id AND community_membership.community_id=:community_id ', ['community_id' => $this->id]);
        $query->andWhere('community_membership.community_id IS NULL');
        $query->orWhere(['!=', 'community_membership.status', Membership::STATUS_MEMBER]);
        $query->addOrderBy(['community_membership.group_id' => SORT_DESC]);
        return $query;
    }

    public function getApplicants()
    {
        $query = $this->hasMany(Membership::class, ['community_id' => 'id']);
        $query->andWhere(['community_membership.status' => Membership::STATUS_APPLICANT]);
        return $query;
    }

    /**
     * Return user groups
     *
     * @return array user groups
     */
    public function getUserGroups()
    {
        $groups = [
            self::USERGROUP_OWNER => Yii::t('CommunityModule.models_Community', 'Owner'),
            self::USERGROUP_ADMIN => Yii::t('CommunityModule.models_Community', 'Administrators'),
            self::USERGROUP_MODERATOR => Yii::t('CommunityModule.models_Community', 'Moderators'),
            self::USERGROUP_MEMBER => Yii::t('CommunityModule.models_Community', 'Members'),
            self::USERGROUP_USER => Yii::t('CommunityModule.models_Community', 'Users')
        ];

        // Add guest groups if enabled
        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess')) {
            $groups[self::USERGROUP_GUEST] = 'Guests';
        }

        return $groups;
    }

    /**
     * @inheritdoc
     */
    public function getUserGroup(User $user = null)
    {
        $user = !$user && !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity() : $user;

        if (!$user) {
            return self::USERGROUP_GUEST;
        }

        /* @var  $membership  Membership */
        $membership = $this->getMembership($user);

        if ($membership && $membership->isMember()) {
            if ($this->isCommunityOwner($user->id)) {
                return self::USERGROUP_OWNER;
            }
            return $membership->group_id;
        } else {
            return self::USERGROUP_USER;
        }
    }

    /**
     * Returns the default content visibility
     *
     * @see Content
     * @return int the default visiblity
     */
    public function getDefaultContentVisibility()
    {
        if ($this->default_content_visibility === null) {
            $globalDefault = Yii::$app->getModule('community')->settings->get('defaultContentVisibility');
            if ($globalDefault == Content::VISIBILITY_PUBLIC) {
                return Content::VISIBILITY_PUBLIC;
            }
        } elseif ($this->default_content_visibility === 1) {
            return Content::VISIBILITY_PUBLIC;
        }

        return Content::VISIBILITY_PRIVATE;
    }

}
