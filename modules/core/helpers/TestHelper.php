<?php

namespace zikwall\easyonline\modules\core\helpers;

use Yii;

class TestHelper
{
    /**
     * @return array[]
     *   Format: $[] = ['title' => .., 'state' => [OK, WARNING or ERROR], 'hint']
     */
    public static function getResults() : array
    {
        $checks = [];

        // Checks PHP Version
        $title = 'PHP - Version - ' . PHP_VERSION;

        if (version_compare(PHP_VERSION, '5.6', '>=')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Minimum 5.6'
            ];
        }

        // Checks GD Extension
        $title = 'PHP - GD Extension';

        if (function_exists('gd_info')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install GD Extension'
            ];
        }

        // Checks INTL Extension
        $title = 'PHP - INTL Extension';

        if (function_exists('collator_create')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install INTL Extension'
            ];
        }

        $icuVersion = (defined('INTL_ICU_VERSION')) ? INTL_ICU_VERSION : 0;
        $icuMinVersion = '4.8.1';

        $title = 'PHP - INTL Extension - ICU Version (' . $icuVersion . ')';

        if (version_compare($icuVersion, $icuMinVersion, '>=')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'WARNING',
                'hint' => 'ICU Data ' . $icuMinVersion . ' or higher is required'
            ];
        }
        $icuDataVersion = (defined('INTL_ICU_DATA_VERSION')) ? INTL_ICU_DATA_VERSION : 0;
        $icuMinDataVersion = '4.8.1';

        $title = 'PHP - INTL Extension - ICU Data Version (' . $icuDataVersion . ')';

        if (version_compare($icuDataVersion, $icuMinDataVersion, '>=')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'WARNING',
                'hint' => 'ICU Data ' . $icuMinDataVersion . ' or higher is required'
            ];
        }

        // Checks EXIF Extension
        $title = 'PHP - EXIF Extension';

        if (function_exists('exif_read_data')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install EXIF Extension'
            ];
        }

        // Check FileInfo Extension
        $title = 'PHP - FileInfo Extension';

        if (extension_loaded('fileinfo')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install FileInfo Extension'
            ];
        }

        // Checks Multibyte Extension
        $title = 'PHP - Multibyte String Functions';

        if (function_exists('mb_substr')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install PHP Multibyte Extension'
            ];
        }

        // Checks cURL Extension
        $title = 'PHP - cURL Extension';

        if (function_exists('curl_version')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install Curl Extension'
            ];
        }
        // Checks ZIP Extension
        $title = 'PHP - ZIP Extension';

        if (class_exists('ZipArchive')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install PHP ZIP Extension'
            ];
        }

        // Checks APC(u) Extension
        $title = 'PHP - APC(u) Support';

        if (function_exists('apc_add') || function_exists('apcu_add')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'WARNING',
                'hint' => 'Optional - Install APCu Extension for APC Caching'
            ];
        }

        // Checks SQLite3 Extension
        $title = 'PHP - SQLite3 Support';

        if (class_exists('SQLite3')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'WARNING',
                'hint' => 'Optional - Install SQLite3 Extension for DB Caching'
            ];
        }

        // Checks PDO MySQL Extension
        $title = 'PHP - PDO MySQL Extension';

        if (extension_loaded('pdo_mysql')) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Install PDO MySQL Extension'
            ];
        }

        // Checks Writeable Config

        $title = 'Permissions - Config';
        $configFile = dirname(Yii::$app->params['dynamicConfigFile']);
        if (is_writeable($configFile)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $configFile . " writable for the webserver/php!"
            ];
        }

        // Check Runtime Directory
        $title = 'Permissions - Runtime';

        $path = Yii::getAlias('@runtime');
        if (is_writeable($path)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $path . " writable for the webserver/php!"
            ];
        }

        // Check Assets Directory
        $title = 'Permissions - Assets';

        $path = Yii::getAlias('@webroot/assets');
        if (is_writeable($path)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $path . " writable for the webserver/php!"
            ];
        }

        // Check Uploads Directory
        $title = 'Permissions - Uploads';

        $path = Yii::getAlias('@webroot/uploads');
        if (is_writeable($path)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $path . " writable for the webserver/php!"
            ];
        }

        // Check Custom Modules Directory
        $title = 'Permissions - Module Directory';

        $path = Yii::getAlias(Yii::$app->params['moduleCustomPath']);
        if (is_writeable($path)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $path . " writable for the webserver/php!"
            ];
        }
        // Check Custom Modules Directory
        $title = 'Permissions - Dynamic Config';

        $path = Yii::getAlias(Yii::$app->params['dynamicConfigFile']);
        if (!is_file($path)) {
            $path = dirname($path);
        }

        if (is_writeable($path)) {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'OK'
            ];
        } else {
            $checks[] = [
                'title' => Yii::t('base', $title),
                'state' => 'ERROR',
                'hint' => 'Make ' . $path . " writable for the webserver/php!"
            ];
        }

        return $checks;
    }

}
