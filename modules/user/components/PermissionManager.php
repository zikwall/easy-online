<?php

namespace zikwall\easyonline\modules\user\components;

use Yii;
use zikwall\easyonline\modules\core\libs\BasePermission;
use zikwall\easyonline\modules\user\models\GroupPermission;
use zikwall\easyonline\modules\core\components\Module;
use zikwall\easyonline\modules\user\models\Group;
use yii\base\Module as BaseModule;

class PermissionManager extends \yii\base\Component
{

    /**
     * User identity.
     * @var User
     */
    public $subject;

    /**
     * Cached Permission array.
     * @var array
     */
    protected $permissions = null;

    /**
     * Permission access cache.
     * @var array
     */
    protected $_access = [];

    /**
     * Verifies a given $permission or $permission array for a permission subject.
     *
     * If $params['all'] is set to true and a $permission array is given all given permissions
     * have to be verified successfully otherwise (default) only one permission test has to pass.
     *
     * @param array|BasePermission|mixed $permission
     * @param array $params
     * @param boolean $allowCaching
     * @return boolean
     */
    public function can($permission, $params = [], $allowCaching = true)
    {
        
        if (is_array($permission)) {
            $verifyAll = isset($params['all']) ? $params['all'] : false;
            foreach ($permission as $current) {
                $can = $this->can($current, $params, $allowCaching);
                if ($can && !$verifyAll) {
                    return true;
                } else if (!$can && $verifyAll) {
                    return false;
                }
            }
            return $verifyAll;
        } else if ($allowCaching) {
            $permission = ($permission instanceof BasePermission) ? $permission : Yii::createObject($permission);
            $key = $permission->getId();
            
            if (!isset($this->_access[$key])) {
                $this->_access[$key] = $this->verify($permission);
            }
            
            return $this->_access[$key];
        } else {
            $permission = ($permission instanceof BasePermission) ? $permission : Yii::createObject($permission);
            return $this->verify($permission);
        }
    }

    /**
     * Verifies a single permission for a given permission subject.
     *
     * @param BasePermission $permission
     * @return boolean
     */
    protected function verify(BasePermission $permission)
    {
        $subject = $this->getSubject();
        if ($subject) {
            return $this->getGroupState($subject->groups, $permission) == BasePermission::STATE_ALLOW;
        }

        return false;
    }

    /**
     * Returns the permission subject identity.
     * If the permission objects $subject property is not set this method returns the currently
     * logged in user identity.
     *
     * @return User
     */
    protected function getSubject()
    {
        return ($this->subject != null) ? $this->subject : Yii::$app->user->getIdentity();
    }

    /**
     * Clears access cache
     */
    public function clear()
    {
        $this->_access = [];
    }

    /**
     * Sets the state for a given groupId.
     *
     * @param string $groupId
     * @param BasePermission $permission
     * @param string $state
     */
    public function setGroupState($groupId, BasePermission $permission, $state)
    {
        $record = $this->getGroupStateRecord($groupId, $permission);

        // No need to store default state
        if ($state === '' || $state === null) {
            if ($record !== null) {
                $record->delete();
            }
            return;
        }

        if ($record === null) {
            $record = $this->createPermissionRecord();
        }

        $record->permission_id = $permission->getId();
        $record->module_id = $permission->moduleId;
        $record->class = $permission->className();
        $record->group_id = $groupId;
        $record->state = $state;
        $record->save();
    }

    /**
     * Returns the group permission state of the given group or goups.
     * If the provided $group is an array we check if one of the group states
     * is a BasePermission::STATE_ALLOW and return this state.
     *
     * @param type $groups either an array of groups or group ids or an single group or goup id
     * @param BasePermission $permission
     * @param type $returnDefaultState
     * @return type
     */
    public function getGroupState($groups, BasePermission $permission, $returnDefaultState = true)
    {
        if (is_array($groups)) {
            $state = "";
            foreach ($groups as $group) {
                $state = $this->getSingleGroupState($group, $permission, $returnDefaultState);
                if ($state === BasePermission::STATE_ALLOW) {
                    return $state;
                }
            }
            return $state;
        }
        return $this->getSingleGroupState($groups, $permission, $returnDefaultState);
    }

    /**
     * Returns the group state
     *
     * @param string $groupId
     * @param BasePermission $permission
     * @param boolean $returnDefaultState
     * @return string the state
     */
    private function getSingleGroupState($groupId, BasePermission $permission, $returnDefaultState = true)
    {
        if ($groupId instanceof Group) {
            $groupId = $groupId->id;
        }

        // Check if database entry exists
        $dbRecord = $this->getGroupStateRecord($groupId, $permission);

        if ($dbRecord !== null) {
            return $dbRecord->state;
        }

        if ($returnDefaultState) {
            return $permission->getDefaultState($groupId);
        }

        return "";
    }

    /**
     * Returns a BasePermission by Id
     *
     * @param string $permissionId
     * @param string $moduleId
     * @return BasePermission
     */
    public function getById($permissionId, $moduleId)
    {
        $module = Yii::$app->getModule($moduleId);

        foreach ($this->getModulePermissions($module) as $permission) {
            if ($permission->hasId($permissionId)) {
                return $permission;
            }
        }

        return null;
    }

    protected function getGroupStateRecord($groupId, BasePermission $permission)
    {
        return $this->getQuery()->andWhere([
            'group_id' => $groupId,
            'module_id' => $permission->moduleId,
            'permission_id' => $permission->getId()
        ])->one();
    }

    /**
     * Returns a list of all Permission objects
     *
     * @return array of BasePermissions
     */
    public function getPermissions()
    {
        if ($this->permissions !== null) {
            return $this->permissions;
        }

        $this->permissions = [];

        // Loop over all active modules
        foreach (Yii::$app->getModules() as $id => $module) {
            // Ensure module is instanciated
            $module = Yii::$app->getModule($id);

            $this->permissions = array_merge($this->permissions, $this->getModulePermissions($module));
        }

        return $this->permissions;
    }

    /**
     * Returns permissions provided by a module
     *
     * @param \yii\base\Module $module
     * @return array of BasePermissions
     */
    protected function getModulePermissions(BaseModule $module)
    {
        $result = [];
        if ($module instanceof Module) {
            $permisisons = $module->getPermissions();
            if (!empty($permisisons)) {
                foreach ($permisisons as $permission) {
                    $result[] = is_string($permission) ? Yii::createObject($permission) : $permission;
                }
            }
        }
        return $result;
    }

    /**
     * Creates a Permission Database record
     *
     * @return GroupPermission
     */
    protected function createPermissionRecord()
    {
        return new GroupPermission();
    }

    /**
     * Creates a Permission Database Query
     *
     * @return \yii\db\ActiveQuery
     */
    protected function getQuery()
    {
        return GroupPermission::find();
    }

    /**
     * Returns Permission Array
     *
     * @param int $groupId id of the group
     * @return array the permission array
     */
    public function createPermissionArray($groupId, $returnOnlyChangeable = false)
    {

        $permissions = [];
        foreach ($this->getPermissions() as $permission) {
            if ($returnOnlyChangeable && !$permission->canChangeState($groupId)) {
                continue;
            }

            $permissions[] = [
                'id' => $permission->id,
                'title' => $permission->title,
                'description' => $permission->description,
                'moduleId' => $permission->moduleId,
                'permissionId' => $permission->id,
                'states' => [
                    BasePermission::STATE_DEFAULT => BasePermission::getLabelForState(BasePermission::STATE_DEFAULT) . ' - ' . BasePermission::getLabelForState($permission->getDefaultState($groupId)),
                    BasePermission::STATE_DENY => BasePermission::getLabelForState(BasePermission::STATE_DENY),
                    BasePermission::STATE_ALLOW => BasePermission::getLabelForState(BasePermission::STATE_ALLOW),
                ],
                'changeable' => $permission->canChangeState($groupId),
                'state' => $this->getGroupState($groupId, $permission, false),
            ];
        }
        return $permissions;
    }

}
