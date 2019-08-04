<?php

namespace zikwall\easyonline\modules\admin\models\forms;

use zikwall\easyonline\modules\user\models\Group;
use zikwall\easyonline\modules\user\models\User;

class AddGroupMemberForm extends \yii\base\Model
{
    /**
     * @var array
     */
    public $userGuids;

    /**
     * @var Group
     */
    public $groupId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userGuids', 'groupId'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userGuids' => 'Add Members'
        ];
    }

    /**
     * Устанавливает пользовательские данные и инициализирует выбор
     */
    public function setUser(int $group)
    {
        // Установить параметры пользователя и текущие настройки группы
        $this->group = $group;
    }

    /**
     * Выравнивает выбранный групповой выбор с помощью db
     */
    public function save() : bool
    {
        $group = $this->getGroup();

        if ($group == null) {
            throw new \yii\web\HttpException(404, \Yii::t('AdminModule.models_form_AddGroupMemberForm', 'Group not found!'));
        }

        foreach ($this->userGuids as $userGuid) {
            $user = User::findIdentityByAccessToken($userGuid);
            if ($user != null) {
               $group->addUser($user);
            }
        }

        return true;
    }

    public function getGroup() : Group
    {
        return Group::findOne($this->groupId);
    }
}
