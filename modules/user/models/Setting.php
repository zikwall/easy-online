<?php

namespace zikwall\easyonline\modules\user\models;

use Yii;
use zikwall\easyonline\modules\content\components\ContentContainerSettingsManager;


/**
 * User settings compatiblity layer class
 * 
 * @deprecated since version 1.1
 * @see ContentContainerSettingsManager
 */
class Setting
{

    /**
     * Sets a user setting
     * 
     * @see ContentContainerSettingsManager::set
     * @param int $userId
     * @param string $name
     * @param string $value
     * @param string $moduleId
     */
    public static function Set($userId, $name, $value, $moduleId = "")
    {
        $user = User::findOne(['id' => $userId]);
        self::getModule($moduleId)->settings->contentContainer($user)->set($name, $value);
    }

    /**
     * Gets a user setting
     * 
     * @see ContentContainerSettingsManager::get
     * @param int $userId
     * @param string $name
     * @param string $moduleId
     * @param string $defaultValue
     * @return string the value
     */
    public static function Get($userId, $name, $moduleId = "", $defaultValue = "")
    {
        $user = User::findOne(['id' => $userId]);
        $value = self::getModule($moduleId)->settings->contentContainer($user)->get($name);
        if ($value === null) {
            return $defaultValue;
        }
        return $value;
    }

    /**
     * Gets correct SettingsManager by module id
     * 
     * @param string $moduleId
     * @return \yii\base\Module
     */
    private static function getModule($moduleId)
    {
        $app = null;
        if ($moduleId === '' || $moduleId === 'base' || $moduleId === 'core') {
            $app = Yii::$app;
        } else {
            $app = Yii::$app->getModule($moduleId);
        }
        return $app;
    }

}
