<?php

namespace zikwall\easyonline\modules\user\models;

use Yii;
use zikwall\easyonline\modules\core\components\ActiveRecord;
use yii\db\ActiveQuery;
use zikwall\easyonline\modules\community\models\Community;

/**
 * @property integer $id
 * @property integer $community_id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Group extends ActiveRecord
{
    const SCENARIO_EDIT = 'edit';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['community_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('UserModule.models_User', 'Name'),
            'managerGuids' => Yii::t('UserModule.models_User', 'Manager'),
            'description' => Yii::t('UserModule.models_User', 'Description'),
            'created_at' => Yii::t('UserModule.models_User', 'Created at'),
            'created_by' => Yii::t('UserModule.models_User', 'Created by'),
            'updated_at' => Yii::t('UserModule.models_User', 'Updated at'),
            'updated_by' => Yii::t('UserModule.models_User', 'Updated by'),
            'show_at_registration' => Yii::t('UserModule.models_User', 'Show At Registration'),
            'show_at_directory' => Yii::t('UserModule.models_User', 'Show At Directory'),
        ];
    }

    /**
     * @return Group
     */
    public static function getAdminGroup()
    {
        return Group::findOne(['is_admin_group' => 1]);
    }

    /**
     * @return int идентификатор администраторской группы
     */
    public static function getAdminGroupId()
    {
        $adminGroupId = Yii::$app->getModule('user')->settings->get('group.adminGroupId');
        if ($adminGroupId == null) {
            $adminGroupId = Group::getAdminGroup()->id;
            Yii::$app->getModule('user')->settings->set('group.adminGroupId', $adminGroupId);
        }
        return $adminGroupId;
    }

    /**
     * @return ActiveQuery менеджеры групп User[]
     */
    public function getManager()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->via('groupUsers',
            function (ActiveQuery $query) {
                $query->where(['is_group_manager' => '1']);
        });
    }

    /**
     * Проверяет, имеет ли данная группа хотя бы один менеджера групп пользователей.
     * @return boolean
     */
    public function hasManager()
    {
        return $this->getManager()->count() > 0;
    }

    /**
     * @param int|User $user
     * @return GroupUser
     */
    public function getGroupUser($user)
    {
        $userId = ($user instanceof User) ? $user->id : $user;
        return GroupUser::findOne(['user_id' => $userId, 'group_id' => $this->id]);
    }

    public function getGroupUsers()
    {
        return $this->hasMany(GroupUser::class, ['group_id' => 'id']);
    }

    public function getUsers()
    {
        $query = User::find();
        $query->leftJoin('group_user', 'group_user.user_id=user.id AND group_user.group_id=:groupId', [
            ':groupId' => $this->id
        ]);
        $query->andWhere(['IS NOT', 'group_user.id', new \yii\db\Expression('NULL')]);
        $query->multiple = true;
        return $query;
    }

    public function hasUsers()
    {
        return $this->getUsers()->count() > 0;
    }

    public function isManager($user)
    {
        $userId = ($user instanceof User) ? $user->id : $user;
        return $this->getGroupUsers()->where(['user_id' => $userId, 'is_group_manager' => true])->count() > 0;
    }

    public function isMember($user)
    {
        return $this->getGroupUser($user) != null;
    }

    public function addUser($user, $isManager = false)
    {
        if ($this->isMember($user)) {
            return;
        }

        $userId = ($user instanceof User) ? $user->id : $user;

        $newGroupUser = new GroupUser();
        $newGroupUser->user_id = $userId;
        $newGroupUser->group_id = $this->id;
        $newGroupUser->created_at = new \yii\db\Expression('NOW()');
        $newGroupUser->created_by = Yii::$app->user->id;
        $newGroupUser->is_group_manager = $isManager;
        $newGroupUser->save();
    }

    public function removeUser($user)
    {
        $groupUser = $this->getGroupUser($user);
        if ($groupUser != null) {
            $groupUser->delete();
        }
    }

    public static function getRegistrationGroups()
    {
        $groups = [];

        $defaultGroup = Yii::$app->getModule('user')->settings->get('auth.defaultUserGroup');
        if ($defaultGroup != '') {
            $group = self::findOne(['id' => $defaultGroup]);
            if ($group !== null) {
                $groups[] = $group;
                return $groups;
            }
        } else {
            $groups = self::find()->where(['show_at_registration' => '1'])->orderBy('name ASC')->all();
        }

        return $groups;
    }

    public static function notifyAdminsForUserApproval($user)
    {
        if ($user->status != User::STATUS_NEED_APPROVAL || !Yii::$app->getModule('user')->settings->get('auth.needApproval', 'user')) {
            return;
        }

        if ($user->registrationGroupId == null) {
            return;
        }

        $group = self::findOne($user->registrationGroupId);
        $approvalUrl = \yii\helpers\Url::to(["/admin/approval"], true);

        foreach ($group->manager as $manager) {

            Yii::$app->i18n->setUserLocale($manager);

            $html = Yii::t('UserModule.adminUserApprovalMail', 'Hello {displayName},', ['displayName' => $manager->displayName]) . "<br><br>\n\n" .
                Yii::t('UserModule.adminUserApprovalMail', 'a new user {displayName} needs approval.', ['displayName' => $user->displayName]) . "<br><br>\n\n" .
                Yii::t('UserModule.adminUserApprovalMail', 'Please click on the link below to view request:') . "<br>\n\n" .
                \yii\helpers\Html::a($approvalUrl, $approvalUrl) . "<br/> <br/>\n";

            $mail = Yii::$app->mailer->compose(['html' => '@easyonline/modules/core/views/mail/TextOnly'], [
                'message' => $html,
            ]);

            $mail->setTo($manager->email);
            $mail->setSubject(Yii::t('UserModule.adminUserApprovalMail', "New user needs approval"));
            $mail->send();
        }

        Yii::$app->i18n->autosetLocale();

        return true;
    }

    public static function getDirectoryGroups()
    {
        return self::find()->where(['show_at_directory' => '1'])->orderBy('name ASC')->all();
    }
}
