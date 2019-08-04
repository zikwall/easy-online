<?php

namespace zikwall\easyonline\modules\core\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use zikwall\easyonline\modules\core\components\base\Theme;

class ThemeHelper
{
    public static function getThemes() : array
    {
        $themes = self::getThemesByPath(Yii::getAlias('@easyonline/themes'));

        // Собираем темы, предоставляемые модулями
        foreach (Yii::$app->getModules() as $id => $module) {
            if (is_array($module)) {
                $module = Yii::$app->getModule($id);
            }

            $moduleThemePath = $module->getBasePath() . DIRECTORY_SEPARATOR . 'themes';
            if (is_dir($moduleThemePath)) {
                $themes = ArrayHelper::merge($themes, self::getThemesByPath($moduleThemePath, ['publishResources' => true]));
            }
        }

        return $themes;
    }

    /**
     * Возвращает массив экземпляров темы данного каталога
     *
     * @param string $path the theme directory
     * @param array $additionalOptions options for Theme
     * @return Theme[]
     */
    public static function getThemesByPath(string $path, array $additionalOptions = []) : array
    {
        $themes = [];
        if (is_dir($path)) {
            foreach (scandir($path) as $file) {

                // Skip dots and non directories
                if ($file == "." || $file == ".." || !is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                    continue;
                }

                $themes[] = Yii::createObject(ArrayHelper::merge([
                    'class' => 'zikwall\easyonline\modules\core\components\base\Theme',
                    'basePath' => $path . DIRECTORY_SEPARATOR . $file,
                    'name' => $file
                ], $additionalOptions));
            }
        }

        return $themes;
    }

    /**
     * Возвращает тему по названию
     */
    public static function getThemeByName(string $name) : Theme
    {
        foreach (self::getThemes() as $theme) {
            if ($theme->name === $name) {
                return $theme;
            }
        }

        return null;
    }

    /**
     * Возвращает конфигурационный массив заданной темы
     */
    public static function getThemeConfig($theme) : array
    {
        if (is_string($theme)) {
            $theme = self::getThemeByName($theme);
        }

        if ($theme === null) {
            return [];
        }

        $theme->beforeActivate();

        return [
            'components' => [
                'view' => [
                    'theme' => [
                        'name' => $theme->name,
                        'basePath' => $theme->getBasePath(),
                        'publishResources' => $theme->publishResources,
                    ],
                ],
                'mailer' => [
                    'view' => [
                        'theme' => [
                            'name' => $theme->name,
                            'basePath' => $theme->getBasePath(),
                            'publishResources' => $theme->publishResources,
                        ]
                    ]
                ]
            ]
        ];
    }

}
