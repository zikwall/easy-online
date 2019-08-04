<?php

namespace zikwall\easyonline\modules\core\components;

use yii\base\BootstrapInterface;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;
use zikwall\easyonline\modules\core\commands\MigrateController;
use zikwall\easyonline\modules\core\components\managers\SettingsManager;
use zikwall\easyonline\modules\core\models\Setting;
use Yii;
use yii\helpers\Json;

class Module extends \yii\base\Module
{
    /**
     * @var array загруженный файл module.json
     */
    private $_moduleInfo = null;

    /**
     * Путь к ресурсам модуля (изображения, js, css)
     * Также здесь должны быть размещены связанные с модулем активы, такие как README.md и module_image.png.
     */
    public $resourcesPath = 'assets';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->set('settings', [
            'class' => SettingsManager::class,
            'moduleId' => $this->id
        ]);

        parent::init();

    }

    /**
     * Возвращает имя модуля, предоставленное файлом module.json
     *
     * @return string
     *  Format: name
     */
    public function getName()
    {
        $info = $this->getModuleInfo();

        if ($info['name']) {
            return $info['name'];
        }

        return $this->id;
    }

    /**
     * Возвращает описание модулей, предоставленное файлом module.json
     *
     * @return string Description
     */
    public function getDescription()
    {
        $info = $this->getModuleInfo();

        if ($info['description']) {
            return $info['description'];
        }

        return "";
    }

    /**
     * Возвращает номер версии модулей, предоставленный файлом module.json
     */
    public function getVersion() : string
    {
        $info = $this->getModuleInfo();

        if ($info['version']) {
            return $info['version'];
        }

        return '1.0';
    }

    /**
     * Возвращает URL-адрес изображения для этого модуля
     * Для показа икони модуля, изображение должно находиться в <resourcesPath>/module_image.png
     */
    public function getImage()
    {
        $url = $this->getPublishedUrl('/module_image.png');

        if ($url == null) {
            $url = Yii::getAlias('@zikwall/easyonline/modules/core/web/static/img/default_module.jpg');
            Yii::$app->assetManager->publish($url, ['forceCopy' => true]);
            $url = Yii::$app->assetManager->getPublishedUrl($url);
        }

        return $url;
    }

    /**
     * Возвращает URL-адрес файла актива и публикует все активы модуля, если файл еще не опубликован.
     *
     * @param string $relativePath
     * @return string
     */
    public function getPublishedUrl(string $relativePath)
    {
        $path = $this->getAssetPath();

        // Если файл еще не опубликован - публиковать ресурсы модуля
        if (!$this->isPublished($relativePath)) {
            $this->publishAssets();
        }

        // Если он еще не опубликован, файл не существует
        if ($this->isPublished($relativePath)) {
            return Yii::$app->assetManager->getPublishedUrl($path) . $relativePath;
        }
    }

    /**
     * Проверяет, был ли уже опубликован конкретный файл актива
     *
     * @param string $relativePath
     * @return bool
     */
    public function isPublished(string $relativePath)
    {
        $path = $this->getAssetPath();
        $publishedPath = Yii::$app->assetManager->getPublishedPath($path);

        return $publishedPath !== false && is_file($publishedPath . $relativePath);
    }

    /**
     * @return string
     */
    public function getAssetsUrl() : string
    {
        if (($published = $this->publishAssets()) != null) {
            return $published[1];
        }
    }

    /**
     * Публикует каталог basePath / resourcesPath (assets), если он существует.
     *
     * @return array
     */
    public function publishAssets()
    {
        if ($this->hasAssets()) {
            return Yii::$app->assetManager->publish($this->getAssetPath(), ['forceCopy' => true]);
        }
    }

    /**
     * Определяет, имеет ли этот модуль каталог ресурсов.
     *
     * @return bool
     */
    private function hasAssets() : bool
    {
        $path = $this->getAssetPath();
        $path = Yii::getAlias($path);

        return is_string($path) && is_dir($path);
    }

    /**
     * @return string
     */
    public function getAssetPath()
    {
        return $this->getBasePath() . '/' . $this->resourcesPath;
    }

    /**
     * Активация модуля
     *
     * @return bool
     */
    public function enable()
    {
        Yii::$app->moduleManager->enable($this);
        $this->migrate();

        return true;
    }

    /**
     * Деактивация модуля
     *
     * Данное действие должно удалить все данные, созданные этим модулем.
     * При переопределении этого метода обязательно вызовите вызов `parent :: disable ()`
     *
     * ```php
     * public function disable()
     * {
     *     // custom disable logic
     *     parent::disable();
     * }
     * ```
     */
    public function disable()
    {
        /**
         * Выполнение миграциий модуля Migration::down() в uninstall.php
         */
        $migrationPath = $this->getBasePath() . '/migrations';
        $uninstallMigration = $migrationPath . '/uninstall.php';
        if (file_exists($uninstallMigration)) {

            /**
             * Выполнить удаление миграции
             */
            ob_start();
            require_once($uninstallMigration);
            $migration = new \uninstall;
            try {
                $migration->up();
            } catch (\yii\db\Exception $ex) {
                Yii::error($ex);
            }
            ob_get_clean();

            /**
             * Удалить все записи таблицы миграции
             */
            $migrations = opendir($migrationPath);
            while (false !== ($migration = readdir($migrations))) {
                if ($migration == '.' || $migration == '..' || $migration == 'uninstall.php') {
                    continue;
                }
                Yii::$app->db->createCommand()->delete('migration', ['version' => str_replace('.php', '', $migration)])->execute();
            }
        }

        foreach (Setting::findAll(['module_id' => $this->id]) as $containerSetting) {
            $containerSetting->delete();
        }


        Yii::$app->moduleManager->disable($this);
    }

    /**
     * Выполнять все не применяемые миграции модулей
     */
    public function migrate()
    {
        $migrationPath = $this->basePath . '/migrations';
        if (is_dir($migrationPath)) {
            MigrateController::webMigrateUp($migrationPath);
        }
    }

    /**
     * Читает module.json, который содержит основную информацию модуля и возвращает его как массив
     */
    protected function getModuleInfo()
    {
        if ($this->_moduleInfo != null) {
            return $this->_moduleInfo;
        }

        $moduleJson = file_get_contents($this->getBasePath() . DIRECTORY_SEPARATOR . 'module.json');

        /*if (!$moduleJson) {
            return '';
        }*/

        return Json::decode($moduleJson);
    }

    /**
     * Этот метод вызывается после выполнения обновления.
     * Вы можете продлить его с помощью собственного процесса обновления.
     */
    public function update()
    {
        $this->migrate();
    }

    /**
     * URL-адрес действия настройки модуля
     * @return string configuration URL string
     */
    public function getConfigUrl()
    {
        return "";
    }

    /**
     * Возвращает список объектов разрешений, предоставляемых этим модулем.
     * Если предоставлен ContentContainer, метод должен возвращать только соответствующие разрешения в контексте контейнера контента.
     */
    public function getPermissions($contentContainer = null)
    {
        return [];
    }
}
