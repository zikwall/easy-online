<?php

namespace zikwall\easyonline\modules\core\models;

use Yii;

/**
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $module_id
 */
class Setting extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'module_id'], 'required'],
            ['value', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'module_id' => 'Module ID',
        ];
    }

    /**
     * @see BaseSettingsManager::isFixed
     * @param string $name
     * @param string $moduleId
     * @return boolean
     */
    public static function IsFixed($name, $moduleId = "")
    {
        return self::getModule($moduleId)->settings->isFixed($name);
    }

    /**
     * enCore app is installed?
     *
     * @return bool
     */
    public static function isInstalled()
    {
        return isset(Yii::$app->params['installed']) && Yii::$app->params['installed'] == true;
    }

    public static function fixModuleIdAndName($name, $moduleId)
    {
        if ($name == 'allowGuestAccess' && $moduleId == 'authentication_internal') {
            return array('allowGuestAccess', 'user');
        } elseif ($name == 'defaultUserGroup' && $moduleId == 'authentication_internal') {
            return array('auth.allowGuestAccess', 'user');
        } elseif ($name == 'systemEmailAddress' && $moduleId == 'mailing') {
            return array('mailer.systemEmailAddress', 'user');
        } elseif ($name == 'systemEmailName' && $moduleId == 'mailing') {
            return array('mailer.systemEmailName', 'user');
        } elseif ($name == 'enabled' && $moduleId == 'proxy') {
            return array('proxy.enabled', 'base');
        } elseif ($name == 'server' && $moduleId == 'proxy') {
            return array('proxy.server', 'base');
        } elseif ($name == 'port' && $moduleId == 'proxy') {
            return array('proxy.port', 'base');
        } elseif ($name == 'user' && $moduleId == 'proxy') {
            return array('proxy.user', 'base');
        } elseif ($name == 'pass' && $moduleId == 'proxy') {
            return array('proxy.password', 'base');
        } elseif ($name == 'noproxy' && $moduleId == 'proxy') {
            return array('proxy.noproxy', 'base');
        }

        return array($name, $moduleId);
    }

    /**
     * @param $moduleId
     * @return null|\yii\base\Module|\yii\console\Application|\yii\web\Application
     * @throws \yii\base\Exception
     */
    public static function getModule($moduleId)
    {
        $module = null;

        if ($moduleId === '' || $moduleId === 'base') {
            $module = Yii::$app;
        } else {
            $module = Yii::$app->getModule($moduleId);
        }
        if ($module === null) {
            throw new \yii\base\Exception("Could not find module: " . $moduleId);
        }

        return $module;
    }

}
