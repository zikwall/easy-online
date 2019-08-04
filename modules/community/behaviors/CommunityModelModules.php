<?php

namespace zikwall\easyonline\modules\community\behaviors;

use Yii;
use yii\base\Behavior;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\content\components\ContentContainerModule;

class CommunityModelModules extends Behavior
{

    public $_enabledModules = null;
    public $_availableModules = null;

    /**
     * Collects a list of all modules which are available for this community
     *
     * @return array
     */
    public function getAvailableModules()
    {

        if ($this->_availableModules !== null) {
            return $this->_availableModules;
        }

        $this->_availableModules = array();

        foreach (Yii::$app->moduleManager->getModules() as $moduleId => $module) {
            if ($module instanceof ContentContainerModule && Yii::$app->hasModule($module->id) && $module->hasContentContainerType(Community::class)) {
                $this->_availableModules[$module->id] = $module;
            }
        }

        return $this->_availableModules;
    }

    /**
     * Returns an array of enabled community modules
     *
     * @return array
     */
    public function getEnabledModules()
    {

        if ($this->_enabledModules !== null) {
            return $this->_enabledModules;
        }

        $this->_enabledModules = array();

        $availableModules = $this->getAvailableModules();
        $defaultStates = \zikwall\easyonline\modules\community\models\Module::getStates();
        $states = \zikwall\easyonline\modules\community\models\Module::getStates($this->owner->id);

        // Get a list of all enabled module ids
        foreach (array_merge(array_keys($defaultStates), array_keys($states)) as $id) {

            // Ensure module Id is available
            if (!array_key_exists($id, $availableModules)) {
                continue;
            }

            if (isset($defaultStates[$id]) && $defaultStates[$id] == \zikwall\easyonline\modules\community\models\Module::STATE_FORCE_ENABLED) {
                // Forced enabled globally
                $this->_enabledModules[] = $id;
            } elseif (!isset($states[$id]) && isset($defaultStates[$id]) && $defaultStates[$id] == \zikwall\easyonline\modules\community\models\Module::STATE_ENABLED) {
                // No local state -> global default on
                $this->_enabledModules[] = $id;
            } elseif (isset($states[$id]) && $states[$id] == \zikwall\easyonline\modules\community\models\Module::STATE_ENABLED) {
                // Locally enabled
                $this->_enabledModules[] = $id;
            }
        }

        return $this->_enabledModules;
    }

    /**
     * Checks if given ModuleId is enabled
     *
     * @param type $moduleId
     */
    public function isModuleEnabled($moduleId)
    {
        return in_array($moduleId, $this->getEnabledModules());
    }

    /**
     * Enables a Module
     */
    public function enableModule($moduleId)
    {

        // Not enabled globally
        if (!array_key_exists($moduleId, $this->getAvailableModules())) {
            return false;
        }

        // Already enabled module
        if ($this->isModuleEnabled($moduleId)) {
            Yii::error("Community->enableModule(" . $moduleId . ") module is already enabled");
            return false;
        }

        // Add Binding
        $communityModule = \zikwall\easyonline\modules\community\models\Module::findOne(['community_id' => $this->owner->id, 'module_id' => $moduleId]);
        if ($communityModule == null) {
            $communityModule = new \zikwall\easyonline\modules\community\models\Module();
            $communityModule->community_id = $this->owner->id;
            $communityModule->module_id = $moduleId;
        }
        $communityModule->state = \zikwall\easyonline\modules\community\models\Module::STATE_ENABLED;
        $communityModule->save();

        $module = Yii::$app->moduleManager->getModule($moduleId);
        $module->enableContentContainer($this->owner);

        return true;
    }

    public function canDisableModule($id)
    {
        $defaultStates = \zikwall\easyonline\modules\community\models\Module::getStates(0);
        if (isset($defaultStates[$id]) && $defaultStates[$id] == \zikwall\easyonline\modules\community\models\Module::STATE_FORCE_ENABLED) {
            return false;
        }

        return true;
    }

    /**
     * Uninstalls a Module
     */
    public function disableModule($moduleId)
    {

        // Not enabled globally
        if (!array_key_exists($moduleId, $this->getAvailableModules())) {
            return false;
        }

        // Already enabled module
        if (!$this->isModuleEnabled($moduleId)) {
            Yii::error("Community->disableModule(" . $moduleId . ") module is not enabled");
            return false;
        }

        // New Way: Handle it directly in module class
        $module = Yii::$app->moduleManager->getModule($moduleId);
        $module->disableContentContainer($this->owner);

        $communityModule = \zikwall\easyonline\modules\community\models\Module::findOne(['community_id' => $this->owner->id, 'module_id' => $moduleId]);
        if ($communityModule == null) {
            $communityModule = new \zikwall\easyonline\modules\community\models\Module();
            $communityModule->community_id = $this->owner->id;
            $communityModule->module_id = $moduleId;
        }
        $communityModule->state = \zikwall\easyonline\modules\community\models\Module::STATE_DISABLED;
        $communityModule->save();

        return true;
    }

}
