<?php
$params = require __DIR__ . '/params.php';

return [
    'name' => '{{App.name}}',
    'language' => 'ru',
    'sourceLanguage' => 'en',
    'homeUrl' => ['/default'],
    'defaultRoute' => '/core/default/home',
    'bootstrap' => ['log','zikwall\easyonline\modules\core\components\bootstrap\AliasesBootstrap','zikwall\easyonline\modules\core\components\bootstrap\ModuleAutoLoader'],
    'components' => [
        'moduleManager' => [
            'class' => 'zikwall\easyonline\modules\core\components\managers\ModuleManager'
        ],
        'request' => [
            'class' => 'zikwall\easyonline\modules\core\components\web\Request',
            'cookieValidationKey' => 'Z6uJ0vDjZlseFP4QSQQrfwvHXVtYvSXs',
            'baseUrl' => ''
        ],
        'formatter' => [
            'class' => 'zikwall\easyonline\modules\core\components\i18n\Formatter',
        ],
        'formatterApp' => [
            'class' => 'yii\i18n\Formatter',
        ],
        'settings' => [
            'class' => 'zikwall\easyonline\modules\core\components\managers\SettingsManager',
            'moduleId' => 'base',
        ],
        'user' => [
            'class' => 'zikwall\easyonline\modules\user\components\User',
            'identityClass' => 'zikwall\easyonline\modules\user\models\User',
            'enableAutoLogin' => true,
            'authTimeout' => 1400,
            'loginUrl' => ['/user/auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'core/error/index',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'i18n' => [
            'class' => 'zikwall\easyonline\modules\core\components\i18n\I18N',
            'translations' => [
                'base' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@zikwall/easyonline/modules/core/messages'
                ],
                'security' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@zikwall/easyonline/modules/core/messages'
                ],
                'error' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@zikwall/easyonline/modules/core/messages'
                ],
            ],
        ],
        'view' => [
            'class' => '\zikwall\easyonline\modules\core\components\base\View',
            'theme' => [
                'class' => '\zikwall\easyonline\modules\core\components\base\Theme',
                'name' => 'core',
            ],
        ],
        'assetManager' => [
            'class' => '\zikwall\easyonline\modules\core\components\managers\AssetManager',
            'appendTimestamp' => true,
            // global clearing
            'bundles' => [
                /*'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],*/
               'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ],
            'forceCopy' => true,
        ],
        /*'session' => [
            'class' => 'zikwall\easyonline\modules\user\components\Session',
            'sessionTable' => 'user_http_session',
        ],*/
        'authClientCollection' => [
            'class' => 'zikwall\easyonline\modules\user\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\VKontakte',
                    'clientId' => '5970173',
                    'clientSecret' => 'vS5FvcUUHElGQtSXysUK',
                    'scope' => 'email'
                ],
                'github' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\GitHub',
                    'clientId' => '77e193997b2f92215f61',
                    'clientSecret' => '17b05e630eaa50ab7d3e576b266c73091400283c',
                    'scope' => 'user:email, user'
                ],
                'google' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\Google',
                    'clientId' => '312154468667-a6c11pagu3uk0fe09vpuje8tj59ilf5n.apps.googleusercontent.com',
                    'clientSecret' => 'Z62RZW1O5-eu2N-woT_h_HBz',
                ],
                'facebook' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\Facebook',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                /*
                'linkedin' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\LinkedIn',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                */
                'live' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\Live',
                    'clientId' => 'XXX',
                    'clientSecret' => 'XXX',
                ],
                'yandex' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\YandexOAuth',
                    'clientId' => '6c78ab38b3b44669aa89e0479c14c9be',
                    'clientSecret' => 'c28d5f1eac064094a7cc0c18c6559b00',
                ],
                /*
                'twitter' => [
                    'class' => 'zikwall\easyonline\modules\user\authclient\Twitter',
                    'consumerKey' => 'XXX',
                    'consumerSecret' => 'XXX',
                ],
                */
            ],
        ],
        'mailer' => [
            'class' => 'zikwall\easyonline\modules\core\components\mail\Mailer',
            'viewPath' => '@core/views/mail',
            'view' => [
                'class' => '\yii\web\View',
                'theme' => [
                    'class' => '\zikwall\easyonline\modules\core\components\base\Theme',
                    'name' => 'core'
                ],
            ],
        ],
    ],
    'params' => $params,
];
