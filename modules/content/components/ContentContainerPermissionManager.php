<?php

namespace zikwall\easyonline\modules\content\components;

use zikwall\easyonline\modules\user\components\PermissionManager;
use zikwall\easyonline\modules\content\models\ContentContainerPermission;
use zikwall\easyonline\modules\core\libs\BasePermission;

/**
 * @inheritdoc
 */
class ContentContainerPermissionManager extends PermissionManager
{

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer = null;

    /**
     * @inheritdoc
     */
    public function verify(BasePermission $permission) : bool
    {
        $groupId = $this->contentContainer->getUserGroup($this->subject);

        if ($this->getGroupState($groupId, $permission) == BasePermission::STATE_ALLOW) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getModulePermissions(\yii\base\Module $module)
    {
        if ($module instanceof \zikwall\easyonline\modules\core\components\Module) {
            return $module->getPermissions($this->contentContainer);
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function createPermissionRecord()
    {
        $permission = new ContentContainerPermission;
        $permission->contentcontainer_id = $this->contentContainer->contentcontainer_id;
        return $permission;
    }

    /**
     * @inheritdoc
     */
    protected function getQuery()
    {
        return ContentContainerPermission::find()
            ->where(['contentcontainer_id' => $this->contentContainer->contentcontainer_id]);
    }

}
