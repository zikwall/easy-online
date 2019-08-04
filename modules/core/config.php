<?php

use zikwall\easyonline\modules\core\Events;

return [
    'id' => 'core',
    'class' => \zikwall\easyonline\modules\core\Module::class,
    'isCoreModule' => true,
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1'],
            'generators' => [
                'module' => [
                    'class' => 'zikwall\easyonline\modules\core\modules\developer\Generator',
                    'templates' => [
                        'core' => '@zikwall/easyonline/modules/core/modules/developer/default',
                    ]
                ]
            ],
        ],
        'developer' => [
            'class' => 'zikwall\easyonline\modules\core\modules\developer\Module'
        ]
    ],
    'events' => [

    ],
    'urlManagerRules' => [
        'error' => 'core/error/index',
        'default' => 'core/default/home',
        'home' => 'core/default/home',
        'developer' => 'core/developer/index',
        'terms' => 'core/default/terms',
    ],
];
?>
