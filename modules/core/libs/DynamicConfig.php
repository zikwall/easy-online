<?php

namespace zikwall\easyonline\modules\core\libs;

use Yii;
use yii\helpers\ArrayHelper;
use zikwall\easyonline\modules\core\helpers\ThemeHelper;

class DynamicConfig extends \yii\base\BaseObject
{

    /**
     * Добавление массива в динамическую конфигурацию
     */
    public static function merge(array $new)
    {
        $config = \yii\helpers\ArrayHelper::merge(self::load(), $new);
        self::save($config);
    }

    /**
     * Возвращает динамическую конфигурацию
     */
    public static function load() : array
    {
        $configFile = self::getConfigFilePath();

        if (!is_file($configFile)) {
            self::save([]);
        }

        /*
         * Загруажается файл с конфигурацей через file_get_contents и eval
         */
        $configContent = str_replace(['<' . '?php', '<' . '?', '?' . '>'], '', file_get_contents($configFile));
        $config = eval($configContent);

        if (!is_array($config))
            return [];

        return $config;
    }

    /**
     * Устанавливает новую динамическую конфигурацию
     */
    public static function save(array $config)
    {
        $content = "<" . "?php return ";
        $content .= var_export($config, true);
        $content .= "; ?" . ">";

        $configFile = self::getConfigFilePath();
        file_put_contents($configFile, $content);

        if (function_exists('opcache_invalidate')) {
            opcache_reset();
            opcache_invalidate($configFile);
        }

        if (function_exists('apc_compile_file')) {
            apc_compile_file($configFile);
        }
    }

    /**
     * Перезаписывает динамическую конфигурацию на основе хранимых настроек базы данных
     */
    public static function rewrite()
    {
        // Получаем текущую конфигурацию
        $config = self::load();

        // Добавление имени приложения в конфигурацию
        $config['name'] = Yii::$app->settings->get('name');

        // Добававление языка по умолчанию
        $defaultLanguage = Yii::$app->settings->get('defaultLanguage');
        if ($defaultLanguage !== null && $defaultLanguage != "") {
            $config['language'] = Yii::$app->settings->get('defaultLanguage');
        } else {
            $config['language'] = Yii::$app->language;
        }

        $timeZone = Yii::$app->settings->get('timeZone');
        if ($timeZone != "") {
            $config['timeZone'] = $timeZone;
            $config['components']['formatter']['defaultTimeZone'] = $timeZone;
            $config['components']['formatterApp']['defaultTimeZone'] = $timeZone;
            $config['components']['formatterApp']['timeZone'] = $timeZone;
        }

        // Добавление кеширования
        $cacheClass = Yii::$app->settings->get('cache.class');
        if (in_array($cacheClass, ['yii\caching\DummyCache', 'yii\caching\FileCache'])) {
            $config['components']['cache'] = [
                'class' => $cacheClass,
                'keyPrefix' => Yii::$app->id
            ];
        } elseif ($cacheClass == 'yii\caching\ApcCache' && (function_exists('apcu_add') || function_exists('apc_add'))) {
            $config['components']['cache'] = [
                'class' => $cacheClass,
                'keyPrefix' => Yii::$app->id,
                'useApcu' => (function_exists('apcu_add'))
            ];
        }

        // Доавбление настроек пользователя
        $config['components']['user'] = array();
        if (Yii::$app->getModule('user')->settings->get('auth.defaultUserIdleTimeoutSec')) {
            $config['components']['user']['authTimeout'] = Yii::$app->getModule('user')->settings->get('auth.defaultUserIdleTimeoutSec');
        }

        // компонент почты
        $mail = [];
        $mail['transport'] = array();
        if (Yii::$app->settings->get('mailer.transportType') == 'smtp') {
            $mail['transport']['class'] = 'Swift_SmtpTransport';

            if (Yii::$app->settings->get('mailer.hostname')) {
                $mail['transport']['host'] = Yii::$app->settings->get('mailer.hostname');
            }

            if (Yii::$app->settings->get('mailer.username')) {
                $mail['transport']['username'] = Yii::$app->settings->get('mailer.username');
            } else if (!Yii::$app->settings->get('mailer.password')) {
                $mail['transport']['authMode'] = 'null';
            }

            if (Yii::$app->settings->get('mailer.password')) {
                $mail['transport']['password'] = Yii::$app->settings->get('mailer.password');
            }

            if (Yii::$app->settings->get('mailer.encryption')) {
                $mail['transport']['encryption'] = Yii::$app->settings->get('mailer.encryption');
            }

            if (Yii::$app->settings->get('mailer.port')) {
                $mail['transport']['port'] = Yii::$app->settings->get('mailer.port');
            }
        } elseif (Yii::$app->settings->get('mailer.transportType') == 'php') {
            $mail['transport']['class'] = 'Swift_MailTransport';
        } else {
            $mail['useFileTransport'] = true;
        }
        $config['components']['mailer'] = $mail;
        $config = ArrayHelper::merge($config, ThemeHelper::getThemeConfig(Yii::$app->settings->get('theme')));
        $config['params']['config_created_at'] = time();

        $config['params']['horImageScrollOnMobile'] = Yii::$app->settings->get('horImageScrollOnMobile');

        self::save($config);
    }

    public static function getConfigFilePath() : string
    {
        return Yii::getAlias(Yii::$app->params['dynamicConfigFile']);
    }

}
