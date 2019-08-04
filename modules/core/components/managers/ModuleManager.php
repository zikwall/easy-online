<?php

namespace zikwall\easyonline\modules\core\components\managers;

use Yii;
use yii\base\Exception;
use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use zikwall\easyonline\modules\core\components\bootstrap\ModuleAutoLoader;
use zikwall\easyonline\modules\core\components\console\Application;
use zikwall\easyonline\modules\core\components\Module;
use zikwall\easyonline\modules\core\models\ModuleEnabled;

class ModuleManager extends \yii\base\Component
{

    /**
     * Создание резервной копии при удалении папки модуля
     *
     * @var boolean
     */
    public $createBackup = true;

    /**
     * Список всех модулей, также содержит установленные, но не включенные модули.
     *
     * @var array
     */
    protected $modules;

    /**
     * Список всех активированных модулей
     *
     * @var array module id's
     */
    public $enabledModules = [];

    /**
     * Список основных классов модулей.
     *
     * @var array the core module class names
     */
    public $coreModules = [];

    public function init()
    {
        parent::init();

        // Любая база данных установлена и не установлена в установленном состоянии
        if (!Yii::$app->params['databaseInstalled'] && !Yii::$app->params['installed']) {
            return;
        }

        if (Yii::$app instanceof Application && !Yii::$app->isDatabaseInstalled()) {
            $this->enabledModules = [];
        } else {
            $this->enabledModules = ModuleEnabled::getEnabledIds();
        }
    }


    /**
     * @param array $configs
     * @throws InvalidConfigException
     */
    public function registerBulk(array $configs)
    {
        foreach ($configs as $basePath => $config) {
            $this->register($basePath, $config);
        }
    }

    /**
     * @param string $basePath the modules base path
     * @param array $config the module configuration (config.php)
     * @throws InvalidConfigException
     */
    public function register(string $basePath, array $config = null) : void
    {
        if ($config === null && is_file($basePath . '/config.php')) {
            $config = require($basePath . '/config.php');
        }

        // Проверка обязательных параметров конфигурации
        if (!isset($config['class']) || !isset($config['id'])) {
            throw new InvalidConfigException("Module configuration requires an id and class attribute!");
        }

        $isCoreModule = (isset($config['isCoreModule']) && $config['isCoreModule']);
        $isInstallerModule = (isset($config['isInstallerModule']) && $config['isInstallerModule']);

        $this->modules[$config['id']] = $config['class'];

        if (isset($config['namespace'])) {
            Yii::setAlias('@' . str_replace('\\', '/', $config['namespace']), $basePath);
        }

        /**
         * Создание коротких алиасов для модулей, например к ассета модуля "USER" можно обращаться как @user/assets
         */
        Yii::setAlias('@' . $config['id'], $basePath);
        if (isset($config['aliases']) && is_array($config['aliases'])) {
            foreach ($config['aliases'] as $name => $value) {
                Yii::setAlias($name, $value);
            }
        }

        if (!Yii::$app->params['installed'] && $isInstallerModule) {
            $this->enabledModules[] = $config['id'];
        }

        if (!$isCoreModule && !in_array($config['id'], $this->enabledModules)) {
            return;
        }

        if (!isset($config['modules'])) {
            $config['modules'] = [];
        }

        if ($isCoreModule) {
            $this->coreModules[] = $config['class'];
        }

        if (isset($config['urlManagerRules'])) {
            Yii::$app->urlManager->addRules($config['urlManagerRules'], false);
        }

        $moduleConfig = [
            'class' => $config['class'],
            'modules' => $config['modules']
        ];

        if (isset(Yii::$app->modules[$config['id']]) && is_array(Yii::$app->modules[$config['id']])) {
            $moduleConfig = \yii\helpers\ArrayHelper::merge($moduleConfig, Yii::$app->modules[$config['id']]);
        }

        Yii::$app->setModule($config['id'], $moduleConfig);

        if (isset($config['events'])) {
            foreach ($config['events'] as $event) {
                if (isset($event['class'])) {
                    Event::on($event['class'], $event['event'], $event['callback']);
                } else {
                    Event::on($event[0], $event[1], $event[2]);
                }
            }
        }

        if (isset($config['modules'])){
            $this->registerSubModules($config['id'], $config['modules']);
        }
    }

    /**
     * @param string $parent
     * @param array $modules
     */
    public function registerSubModules(string $parent, array $modules) : void
    {
        $subModules = [];

        foreach ($modules as $module => $subModuleId) {
            $subModule = Yii::$app->getModule($parent)->getModule($module);
            $subModuleBasePath = $subModule->getBasePath();

            if (isset($subModuleId['class']) && is_file( $subModuleBasePath . DIRECTORY_SEPARATOR . 'config.php')){
                if (is_dir($subModuleBasePath)) {
                    try {
                        $subModules[$subModuleBasePath] = require($subModuleBasePath . DIRECTORY_SEPARATOR . 'config.php');
                    } catch (\Exception $ex) {
                        Yii::error($ex);
                    }
                }
            }
        }

        //modules recursion registered, only core modules
        Yii::$app->moduleManager->registerBulk($subModules);
    }

    /**
     * Возвращает все модули (также отключенные модули).
     *
     * Примечание. Возвращаются только модули, которые расширяют ..\core\components\Module.
     *
     * Доступны следующие параметры:
     *
     * - includeCoreModules: boolean, возвращает также основные модули (по умолчанию: false)
     * - returnClass: boolean, возвращает имя класса вместо объекта модуля (по умолчанию: false)
     *
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function getModules(array $options = []) : array
    {
        $modules = [];

        foreach ($this->modules as $id => $class) {

            // Пропустить модули ядра
            if (!isset($options['includeCoreModules']) || $options['includeCoreModules'] === false) {
                if (in_array($class, $this->coreModules)) {
                    continue;
                }
            }

            if (isset($options['returnClass']) && $options['returnClass']) {
                $modules[$id] = $class;
            } else {
                $module = $this->getModule($id);
                if ($module instanceof Module) {
                    $modules[$id] = $module;
                }
            }
        }

        return $modules;
    }

    /**
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function getCoreModules(array $options = []) : array
    {
        $coreModules = [];

        foreach ($this->modules as $id => $class) {

            if (in_array($class, $this->coreModules)) {
                if (isset($options['returnClass']) && $options['returnClass']) {
                    $modules[$id] = $class;
                } else {
                    $module = $this->getModule($id);
                    if ($module instanceof Module) {
                        $coreModules[$id] = $module;
                    }
                }
            }
        }

        return $coreModules;
    }

    /**
     * Проверяет, существует ли moduleId, независимо от того, активирован он или нет
     *
     * @param string $id
     * @return bool
     */
    public function hasModule(string $id) : bool
    {
        return (array_key_exists($id, $this->modules));
    }

    /**
     * Возвращает экземпляр модуля по идентификатору
     *
     * @param string $id
     * @return \yii\base\Module
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getModule(string $id) : \yii\base\Module
    {
        // Активация модуля
        if (Yii::$app->hasModule($id)) {
            return Yii::$app->getModule($id, true);
        }

        // Деактивация модуля
        if (isset($this->modules[$id])) {
            $class = $this->modules[$id];
            return Yii::createObject($class, [$id, Yii::$app]);
        }

        throw new Exception("Could not find/load requested module: " . $id);
    }

    public function flushCache(): void
    {
        Yii::$app->cache->delete(ModuleAutoLoader::CACHE_ID);
    }

    /**
     * Проверяет, может ли модуль быть удаленным
     *
     * @param string $moduleId
     * @return bool
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function canRemoveModule(string $moduleId) : bool
    {
        $module = $this->getModule($moduleId);

        if ($module === null) {
            return false;
        }

        // Проверка находится в папке пользовательских модулей
        if (strpos($module->getBasePath(), Yii::getAlias(Yii::$app->params['moduleCustomPath'])) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Удаляет модуль
     *
     * @param string $moduleId
     * @param bool $disableBeforeRemove
     * @throws Exception
     * @throws InvalidConfigException
     * @throws \yii\base\ErrorException
     */
    public function removeModule(string $moduleId, bool $disableBeforeRemove = true) : void
    {
        $module = $this->getModule($moduleId);

        if ($module == null) {
            throw new Exception("Could not load module to remove!");
        }

        /**
         * Деактивация модуля
         */
        if ($disableBeforeRemove && Yii::$app->hasModule($moduleId)) {
            $module->disable();
        }

        /**
         * Удаление папки
         */
        if ($this->createBackup) {
            $moduleBackupFolder = Yii::getAlias("@runtime/module_backups");
            if (!is_dir($moduleBackupFolder)) {
                if (!@mkdir($moduleBackupFolder)) {
                    throw new Exception("Could not create module backup folder!");
                }
            }

            $backupFolderName = $moduleBackupFolder . DIRECTORY_SEPARATOR . $moduleId . "_" . time();
            $moduleBasePath = $module->getBasePath();
            FileHelper::copyDirectory($moduleBasePath, $backupFolderName);
            FileHelper::removeDirectory($moduleBasePath);
        } else {
            //TODO: Delete directory
        }

        $this->flushCache();
    }

    /**
     * @param Module $module
     * @throws InvalidConfigException
     */
    public function enable(Module $module) : void
    {
        $moduleEnabled = ModuleEnabled::findOne(['module_id' => $module->id]);
        if ($moduleEnabled == null) {
            $moduleEnabled = new ModuleEnabled();
            $moduleEnabled->module_id = $module->id;
            $moduleEnabled->save();
        }

        $this->enabledModules[] = $module->id;
        $this->register($module->getBasePath());
    }

    /**
     * @param array $modules
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function enableModules(array $modules = []) : void
    {
        foreach ($modules as $module) {
            $module = ($module instanceof Module) ? $module : $this->getModule($module);
            if ($module != null) {
                $module->enable();
            }
        }
    }

    /**
     * @param Module $module
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function disable(Module $module) : void
    {
        $moduleEnabled = ModuleEnabled::findOne(['module_id' => $module->id]);
        if ($moduleEnabled != null) {
            $moduleEnabled->delete();
        }

        if (($key = array_search($module->id, $this->enabledModules)) !== false) {
            unset($this->enabledModules[$key]);
        }

        Yii::$app->setModule($module->id, 'null');
    }

    /**
     * @param array $modules
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function disableModules(array $modules = []) : void
    {
        foreach ($modules as $module) {
            $module = ($module instanceof Module) ? $module : $this->getModule($module);
            if ($module != null) {
                $module->disable();
            }
        }
    }
}
