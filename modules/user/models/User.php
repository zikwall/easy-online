<?php

namespace zikwall\easyonline\modules\user\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use zikwall\easyonline\modules\core\behaviors\GUID;
use zikwall\easyonline\modules\user\behaviors\UserModelModules;
use zikwall\easyonline\modules\user\components\ActiveQueryUser;
use zikwall\easyonline\modules\user\widgets\HeaderMenu;
use zikwall\easyonline\modules\user\behaviors\Followable;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;

/**
 *
 * @property integer $id
 * @property string $guid
 * @property integer $status
 * @property string $username
 * @property string $email
 * @property string $auth_mode
 * @property string $tags
 * @property string $language
 * @property string $time_zone
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $last_login
 * @property integer $visibility
 * @property integer $contentcontainer_id
 *
 * @property Profile $profile
 * @property Group[] $groups
 */
class User extends ContentContainerActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * User Status Flags
     */
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;
    const STATUS_NEED_APPROVAL = 2;

    /**
     * Visibility Modes
     */
    const VISIBILITY_REGISTERED_ONLY = 1; // Only for registered members
    const VISIBILITY_ALL = 2; // Visible for all (also guests)

    /**
     * User Groups
     */
    const USERGROUP_SELF = 'u_self';
    const USERGROUP_FRIEND = 'u_friend';
    const USERGROUP_USER = 'u_user';
    const USERGROUP_GUEST = 'u_guest';

    /**
     * A initial group for the user assigned while registration.
     * @var string
     */
    public $registrationGroupId = null;

    /**
     * @var boolean is system admin (cached)
     */
    private $_isSystemAdmin = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['status', 'created_by', 'updated_by', 'visibility'], 'integer'],
            [['status', 'visibility'], 'integer'],
            [['tags'], 'string'],
            [['guid'], 'string', 'max' => 45],
            [['username'], 'string', 'max' => 50, 'min' => Yii::$app->getModule('user')->minimumUsernameLength],
            [['time_zone'], 'in', 'range' => \DateTimeZone::listIdentifiers()],
            [['auth_mode'], 'string', 'max' => 10],
            [['language'], 'string', 'max' => 5],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['guid'], 'unique'],
        ];
    }

    /**
     * Checks if user is system administrator
     *
     * @param boolean $cached Used cached result if available
     * @return boolean user is system admin
     */
    public function isSystemAdmin($cached = true)
    {
        if ($this->_isSystemAdmin === null || !$cached) {
            $this->_isSystemAdmin = ($this->getGroups()->where(['is_admin_group' => '1'])->count() > 0);
        }

        return $this->_isSystemAdmin;
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {

        if ($name == 'super_admin') {
            /**
             * Replacement for old super_admin flag version
             */
            return $this->isSystemAdmin();
        } else if ($name == 'profile') {
            /**
             * Ensure there is always a related Profile Model also when it's
             * not really exists yet.
             */
            $profile = parent::__get('profile');
            if (!$this->isRelationPopulated('profile') || $profile === null) {
                $profile = new Profile();
                $profile->user_id = $this->id;
                $this->populateRelation('profile', $profile);
            }
            return $profile;
        }
        return parent::__get($name);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['login'] = ['username', 'password'];
        $scenarios['editAdmin'] = ['username', 'email', 'status'];
        $scenarios['registration_email'] = ['username', 'email'];
        $scenarios['registration'] = ['username'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'status' => Yii::t('UserModule.models_User', 'Status'),
            'username' => Yii::t('UserModule.models_User', 'Username'),
            'email' => Yii::t('UserModule.models_User', 'Email'),
            'profile.firstname' => Yii::t('UserModule.models_Profile', 'First name'),
            'profile.lastname' => Yii::t('UserModule.models_Profile', 'Last name'),
            'auth_mode' => Yii::t('UserModule.models_User', 'Auth Mode'),
            'tags' => Yii::t('UserModule.models_User', 'Tags'),
            'language' => Yii::t('UserModule.models_User', 'Language'),
            'created_at' => Yii::t('UserModule.models_User', 'Created at'),
            'created_by' => Yii::t('UserModule.models_User', 'Created by'),
            'updated_at' => Yii::t('UserModule.models_User', 'Updated at'),
            'updated_by' => Yii::t('UserModule.models_User', 'Updated by'),
            'last_login' => Yii::t('UserModule.models_User', 'Last Login'),
            'visibility' => Yii::t('UserModule.models_User', 'Visibility'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            GUID::class,
            Followable::class,
            UserModelModules::class
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['guid' => $token]);
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return Yii::createObject(ActiveQueryUser::class, [get_called_class()]);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->guid;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getCurrentPassword()
    {
        return $this->hasOne(Password::class, ['user_id' => 'id'])->orderBy('created_at DESC');
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }
	
    /**
     * @return ActiveQuery
     */
    public function getGroupUsers()
    {
        return $this->hasMany(GroupUser::class, ['user_id' => 'id']);
    }

    /**
     * Returns all Group relations of this user as ActiveQuery
     * @return ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->via('groupUsers');
    }

    /**
     * Checks if the user has at least one group assigned.
     * @return boolean
     */
    public function hasGroup()
    {
        return $this->getGroups()->count() > 0;
    }

    /**
     * Returns all GroupUser relations this user is a manager of as ActiveQuery.
     * @return ActiveQuery
     */
    public function getManagerGroupsUser()
    {
        return $this->getGroupUsers()->where(['is_group_manager' => '1']);
    }

    /**
     * Returns all Groups this user is a maanger of as ActiveQuery.
     * @return ActiveQuery
     */
    public function getManagerGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->via('groupUsers', function($query) {
            $query->andWhere(['is_group_manager' => '1']);
        });
    }

    /**
     * Returns all user this user is related as friend as ActiveQuery.
     * Returns null if the friendship module is deactivated.
     * @return ActiveQuery
     */
    public function getFriends()
    {
        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            return Friendship::getFriendsQuery($this);
        }
        return null;
    }

    public function isActive()
    {
        return $this->status === User::STATUS_ENABLED;
    }

    /**
     * Before Delete of a User
     *
     */
    public function beforeDelete()
    {
        // Disable all enabled modules
        foreach ($this->getAvailableModules() as $moduleId => $module) {
            if ($this->isModuleEnabled($moduleId)) {
                $this->disableModule($moduleId);
            }
        }

        // Remove from search index
        Yii::$app->search->delete($this);

        // Cleanup related tables
        Invite::deleteAll(['user_originator_id' => $this->id]);
        Follow::deleteAll(['user_id' => $this->id]);
        Follow::deleteAll(['object_model' => $this->className(), 'object_id' => $this->id]);
        Password::deleteAll(['user_id' => $this->id]);
        Profile::deleteAll(['user_id' => $this->id]);
        GroupUser::deleteAll(['user_id' => $this->id]);
        Session::deleteAll(['user_id' => $this->id]);

        return parent::beforeDelete();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {

            if ($this->auth_mode == '') {
                $passwordAuth = new \zikwall\easyonline\modules\user\authclient\Password();
                $this->auth_mode = $passwordAuth->getId();
            }

            if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess')) {
                // Set users profile default visibility to all
                if (Yii::$app->getModule('user')->settings->get('auth.defaultUserProfileVisibility') == User::VISIBILITY_ALL) {
                    $this->visibility = User::VISIBILITY_ALL;
                }
            }

            if ($this->status == "") {
                $this->status = self::STATUS_ENABLED;
            }
        }

        if ($this->time_zone == "") {
            $this->time_zone = Yii::$app->settings->get('timeZone');
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Make sure we get an direct User model instance
        // (e.g. not UserEditForm) for search rebuild
        $user = User::findOne(['id' => $this->id]);

        /*if ($this->status == User::STATUS_ENABLED) {
            Yii::$app->search->update($user);
        } else {
            Yii::$app->search->delete($user);
        }*/

        if ($insert) {
            Group::notifyAdminsForUserApproval($this);
            $this->profile->user_id = $this->id;
        }

        if (Yii::$app->user->id == $this->id) {
            Yii::$app->user->setIdentity($user);
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns users display name
     *
     * @return string the users display name (e.g. firstname + lastname)
     */
    public function getDisplayName()
    {
        if (Yii::$app->getModule('user')->displayNameCallback !== null) {
            return call_user_func(Yii::$app->getModule('user')->displayNameCallback, $this);
        }

        $name = '';

        $format = Yii::$app->settings->get('displayNameFormat');

        if ($this->profile !== null && $format == '{profile.firstname} {profile.lastname}')
            $name = $this->profile->firstname . " " . $this->profile->lastname;

        // Return always username as fallback
        if ($name == '' || $name == ' ')
            return $this->username;

        return $name;
    }

    /**
     * Checks if this records belongs to the current user
     *
     * @return boolean is current User
     */
    public function isCurrentUser()
    {
        if (Yii::$app->user->id == $this->id) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the given $user instance shares the same identity with this
     * user instance.
     *
     * @param User
     * @return boolean
     */
    public function is(User $user)
    {
        return $user->id === $this->id;
    }

    /**
     * @inheritdoc
     */
    public function canAccessPrivateContent(User $user = null)
    {
        $user = !$user && !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity() : $user;

        // Guest
        if (!$user) {
            return false;
        }

        // Self
        if ($user->is($this)) {
            return true;
        }

        // Friend
        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            return (Friendship::getStateForUser($this, $user) == Friendship::STATE_FRIENDS);
        }

        return false;
    }

    /**
     * Проверяет, есть ли у пользователя теги
     *
     * @return boolean
     */
    public function hasTags()
    {
        return ($this->tags != '');
    }

    /**
     * Возвращает массив с назначенными тегами
     *
     * @return array tags
     */
    public function getTags()
    {
        return preg_split("/[;,#]+/", $this->tags);
    }

    public function createUrl($route = null, $params = array(), $scheme = false)
    {
        if ($route === null) {
            $route = '/user/profile';
        }

        array_unshift($params, $route);
        if (!isset($params['uguid'])) {
            $params['uguid'] = $this->guid;
        }

        return \yii\helpers\Url::toRoute($params, $scheme);
    }

    /**
     * @return ActiveQuery
     */
    public function getHttpSessions()
    {
        return $this->hasMany(Session::class, ['user_id' => 'id']);
    }

    /**
     * Пользователь может одобрить других пользователей
     *
     * @return boolean
     */
    public function canApproveUsers()
    {
        if ($this->isSystemAdmin()) {
            return true;
        }

        return $this->getManagerGroups()->count() > 0;
    }

    /**
     * @return ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::class, ['user_id' => 'id']);
    }

    /**
     * TODO: deprecated
     * @inheritdoc
     */
    public function getUserGroup(User $user = null)
    {
        $user = !$user && !Yii::$app->user->isGuest ? Yii::$app->user->getIdentity() : $user;

        if (!$user) {
            return self::USERGROUP_GUEST;
        } elseif ($this->is($user)) {
            return self::USERGROUP_SELF;
        }

        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            if (Friendship::getStateForUser($this, $user) === Friendship::STATE_FRIENDS) {
                return self::USERGROUP_FRIEND;
            }
        }

        return self::USERGROUP_USER;
    }

    public function getUserClientId($id, $client)
    {

        $user = $user = Auth::find()
            ->andWhere([
                'and',
                ['user_id' => $id],
                ['source' => $client],
            ])->one();

        return $user->source_id;
    }

}
