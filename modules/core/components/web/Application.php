<?php

namespace zikwall\easyonline\modules\core\components\web;

use Yii;
use yii\helpers\Url;
use yii\base\Exception;

/**
 * @inheritdoc
 */
class Application extends \yii\web\Application
{
    /**
     * @var string|array the homepage url
     */
    private $_homeUrl = null;

    public function getHomeUrl() : string
    {
        if ($this->_homeUrl === null) {
            throw new Exception('Home URL not defined!');
        } elseif (is_array($this->_homeUrl)) {
            return Url::to($this->_homeUrl);
        } else {
            return $this->_homeUrl;
        }
    }

    /**
     * @param string|array $value the homepage URL
     */
    public function setHomeUrl($value)
    {
        $this->_homeUrl = $value;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /**
         * Проверка на иницилиазцию установки приложения или это не модуль установщик enCore
         */
        if (!$this->params['installed'] && $this->controller->module != null && $this->controller->module->id != 'installer') {
            $this->controller->redirect(['/installer/index']);
            return false;
        }

        /**
         * Обеспечивает уникальность в атрибутах ajax
         */
        \yii\base\Widget::$autoIdPrefix = 'en' . mt_rand(1, 999999) . 'core';

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function preInit(&$config)
    {
        if (!isset($config['timeZone']) && date_default_timezone_get()) {
            $config['timeZone'] = date_default_timezone_get();
        }

        parent::preInit($config);
    }

}
