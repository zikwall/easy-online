<?php

namespace zikwall\easyonline\modules\core\commands;

use Yii;

/**
 * Управляет миграциями приложений.
 */
class MigrateController extends \yii\console\controllers\MigrateController
{

    /**
     * @var string каталог, в котором хранятся классы миграции. Это может быть псевдоним пути или каталог.
     */
    public $migrationPath = '@zikwall/easyonline/modules/core/migrations';

    /**
     * @var boolean также включают пути миграции всех включенных модулей
     */
    public $includeModuleMigrations = false;

    /**
     * Когда включено включениеModuleMigrations, оно переносит миграции на соответствующий модуль.
     *
     * @var array
     */
    protected $migrationPathMap = [];

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        if ($actionID == 'up') {
            return array_merge(parent::options($actionID), ['includeModuleMigrations']);
        }

        return parent::options($actionID);
    }

    /**
     * Возвращает миграцию, которая не применялась.
     */
    public function getNewMigrations()
    {
        if (!$this->includeModuleMigrations) {
            return parent::getNewMigrations();
        }

        $this->migrationPathMap = [];
        $migrations = [];
        foreach ($this->getMigrationPaths() as $migrationPath) {
            $this->migrationPath = $migrationPath;
            $migrations = array_merge($migrations, parent::getNewMigrations());
            $this->migrationPathMap[$migrationPath] = $migrations;
        }

        sort($migrations);

		return $migrations;
    }

    /**
     * Создает новый экземпляр миграции.
     * @param string $class имя класса миграции
     * @return \yii\db\MigrationInterface экземпляр миграции
     */
    protected function createMigration($class)
    {
        if ($this->includeModuleMigrations) {
            $this->migrationPath = $this->getMigrationPath($class);
        }

		return parent::createMigration($class);
    }

    /**
     * Возвращает путь миграции для данной миграции.
     * Карта, содержащая path => migration, будет создана методом getNewMigrations.
     *
     * @throws \yii\console\Exception
     */
    public function getMigrationPath($migration)
    {
        foreach ($this->migrationPathMap as $path => $migrations) {
            if (in_array($migration, $migrations)) {
                return $path;
            }
        }

		throw new \yii\console\Exception("Could not find path for: " . $migration);
    }

    /**
     * Возвращает пути миграции всех разрешенных модулей
     *
     * @return array
     */
    protected function getMigrationPaths()
    {
        $migrationPaths = ['base' => $this->migrationPath];
        foreach (Yii::$app->getModules() as $id => $config) {
            $class = null;
            if (is_array($config) && isset($config['class'])) {
                $class = $config['class'];
            } elseif ($config instanceof Module) {
                $class = get_class($config);
            }

            if ($class !== null) {
                $reflector = new \ReflectionClass($class);
                $path = dirname($reflector->getFileName()) . '/migrations';
                if (is_dir($path)) {
                    $migrationPaths[$id] = $path;
                }
            }
        }

        return $migrationPaths;
    }

    /**
     * Выполняет все ожидающие миграции
     *
     * @return string output
     */
    public static function webMigrateAll()
    {
        ob_start();
        $controller = new self('migrate', Yii::$app);
        $controller->db = Yii::$app->db;
        $controller->interactive = false;
        $controller->includeModuleMigrations = true;
        $controller->color = false;
        $controller->runAction('up');

		return ob_get_clean();
    }

    /**
     * Выполняет миграцию в определенной папке
     *
     * @param string $migrationPath
     * @return string output
     */
    public static function webMigrateUp($migrationPath)
    {
        ob_start();
        $controller = new self('migrate', Yii::$app);
        $controller->db = Yii::$app->db;
        $controller->interactive = false;
        $controller->migrationPath = $migrationPath;
        $controller->color = false;
        $controller->runAction('up');
        return ob_get_clean();
    }

    /**
     * @inheritdoc
     */
    public function stdout($string)
    {
        if (Yii::$app instanceof \yii\web\Application) {
            print $string;
        } else {
            return parent::stdout($string);
        }
    }

    /**
     * @inheritdoc
     */
    public function stderr($string)
    {
        if (Yii::$app instanceof \yii\web\Application) {
            print $string;
        } else {
            return parent::stderr($string);
        }
    }

}
