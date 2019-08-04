<?php

namespace zikwall\easyonline\modules\content\components\behaviors;

use Yii;
use yii\base\Behavior;

class SettingsBehavior extends Behavior
{
    /**
     * Получить значение параметра контейнера содержимого
     */
    public function getSetting(string $name, string $moduleId = "core", string $default = "") : string
    {
        $value = $this->getModule($moduleId)->settings->contentContainer($this->owner)->get($name);
        if ($value === null) {
            return $default;
        }
        return $value;
    }

    /**
     * установить значение параметра контейнера содержимого
     */
    public function setSetting(string $name, string $value, string $moduleId = "")
    {
        $this->getModule($moduleId)->settings->contentContainer($this->owner)->set($name, $value);
    }

    /**
     * Возвращает SettingManager настроек по id модуля
     */
    private function getModule(string $moduleId) : \yii\base\Module
    {
        $app = null;
        if ($moduleId === '' || $moduleId === 'base') {
            $app = Yii::$app;
        } else {
            $app = Yii::$app->getModule($moduleId);
        }

        if ($app === null) {
            throw new \Exception('Could not find module for setting manager: ' . $moduleId);
        }

        return $app;
    }

}
