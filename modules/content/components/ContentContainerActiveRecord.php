<?php

namespace zikwall\easyonline\modules\content\components;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\components\ActiveRecord;
use zikwall\easyonline\modules\content\models\ContentContainer;

abstract class ContentContainerActiveRecord extends ActiveRecord
{
    /**
     * @var ContentContainerPermissionManager
     */
    protected $permissionManager = null;

    public function getUrl()
    {
        return $this->createUrl();
    }

    /**
     * Создает url в области содержимого контейнера.
     * Например, добавяет параметр uguid в параметры.
     *
     */
    public function createUrl($route = null, $params = [], $scheme = false)
    {
        return "";
    }

    /**
     * Возвращает отображаемое имя контейнера содержимого а
     * - по умолчанию основе названия класса
     * - или пользовательское переопределение
     */
    public function getDisplayName()
    {
        return "Container: " . get_class($this) . " - " . $this->getPrimaryKey();
    }

    /**
     * Проверяет, разрешено ли пользователю доступ к закрытому контенту в этом контейнере
     */
    public function canAccessPrivateContent(User $user = null)
    {
        return false;
    }

    public static function findByGuid(string $token)
    {
        return static::findOne(['guid' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $contentContainer = new ContentContainer;
            $contentContainer->guid = $this->guid;
            $contentContainer->class = $this->className();
            $contentContainer->pk = $this->getPrimaryKey();
            if ($this instanceof User) {
                $contentContainer->owner_user_id = $this->id;
            } elseif ($this->hasAttribute('created_by')) {
                $contentContainer->owner_user_id = $this->created_by;
            }

            $contentContainer->save();

            $this->contentcontainer_id = $contentContainer->id;
            $this->update(false, ['contentcontainer_id']);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        ContentContainer::deleteAll([
            'pk' => $this->getPrimaryKey(),
            'class' => $this->className()
        ]);

        parent::afterDelete();
    }

    public function getContentContainerRecord()
    {
        return $this->hasOne(ContentContainer::class, ['pk' => 'id'])
            ->andOnCondition(['class' => self::class]);
    }

    /**
     * Возвращает allowManager этого контейнера по умолчанию для текущего зарегистрированного пользователя,
     * если не был предоставлен другой экземпляр $user.
     */
    public function getPermissionManager(User $user = null) : ContentContainerPermissionManager
    {
        if ($user && !$user->is(Yii::$app->user->getIdentity())) {
            $permissionManager = new ContentContainerPermissionManager;
            $permissionManager->contentContainer = $this;
            $permissionManager->subject = $user;
            return $permissionManager;
        }

        if ($this->permissionManager !== null) {
            return $this->permissionManager;
        }

        $this->permissionManager = new ContentContainerPermissionManager;
        $this->permissionManager->contentContainer = $this;
        return $this->permissionManager;
    }
    
    /**
     * Ярлык для getPermisisonManager()->can().
     * 
     * Примечание. Этот метод используется для проверки ContentContainerPermissions, а не GroupPermissions.
     * 
     * @param mixed $permission
     * @see PermissionManager::can()
     * @return boolean
     */
    public function can($permission, $params = [], $allowCaching = true)
    {
        return $this->getPermissionManager()->can($permission, $params, $allowCaching);
    }

    /**
     * Возвращает сообщество пользователей для данного $user или текущего зарегистрированного пользователя,
     * если не был указан экземпляр $user.
     */
    public function getUserGroup(User $user = null)
    {
        return "";
    }

    /**
     * Возвращает группы пользователей
     */
    public function getUserGroups()
    {
        return [];
    }
    

    public function isArchived()
    {
        return false;
    }

}
