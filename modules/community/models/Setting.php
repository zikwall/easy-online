<?php



namespace zikwall\easyonline\modules\community\models;

use Yii;


/**
 * Community settings compatiblity layer class
 * 
 * @deprecated since version 1.1
 * @see \zikwall\easyonline\modules\content\components\ContentContainerSettingsManager
 */
class Setting
{

    /**
     * Sets a community setting
     * 
     * @see \zikwall\easyonline\modules\content\components\ContentContainerSettingsManager::set
     * @param type $communityId
     * @param type $name
     * @param type $value
     * @param type $moduleId
     */
    public static function Set($communityId, $name, $value, $moduleId = "")
    {
        $user = Community::findOne(['id' => $communityId]);
        self::getModule($moduleId)->settings->contentContainer($user)->set($name, $value);
    }

    /**
     * Gets a community setting
     * 
     * @see \zikwall\easyonline\modules\content\components\ContentContainerSettingsManager::get
     * @param int $communityId
     * @param string $name
     * @param string $moduleId
     * @param string $defaultValue
     * @return string
     */
    public static function Get($community, $name, $moduleId = "", $defaultValue = "")
    {
        $user = Community::findOne(['id' => $community]);
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
