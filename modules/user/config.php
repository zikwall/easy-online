<?php

//use zikwall\easyonline\modules\search\engine\Search;
use zikwall\easyonline\modules\user\Events;
//use zikwall\easyonline\modules\core\commands\IntegrityController;
use zikwall\easyonline\modules\content\components\ContentAddonActiveRecord;
use zikwall\easyonline\modules\content\components\ContentActiveRecord;
//use zikwall\easyonline\modules\core\commands\CronController;
use zikwall\easyonline\modules\core\components\web\Application;

return [
    'id' => 'user',
    'class' => \zikwall\easyonline\modules\user\Module::class,
    'isCoreModule' => true,
    'urlManagerRules' => [
        ['class' => 'zikwall\easyonline\modules\user\components\UrlRule']
    ],
    'modules' => [
        'friendship' => [
            'class' => 'zikwall\easyonline\modules\user\modules\friendship\Module',
        ],
    ],
    'events' => [
        [
            'class' => \zikwall\easyonline\modules\admin\widgets\AdminSidebarWidget::class,
            'event' => \zikwall\easyonline\modules\admin\widgets\AdminSidebarWidget::EVENT_INIT,
            'callback' => [
                'zikwall\easyonline\modules\user\Events',
                'onAdminMenuInit'
            ],
        ],
        [
            'class' => \zikwall\easyonline\modules\ui\widgets\SidebarMenu::class,
            'event' => \zikwall\easyonline\modules\ui\widgets\SidebarMenu::EVENT_INIT,
            'callback' => [
                'zikwall\easyonline\modules\user\Events',
                'onSidebarInit'
            ],
        ],
        [
            Application::class,
            Application::EVENT_BEFORE_REQUEST,
            ['zikwall\easyonline\modules\user\Events', 'onBeforeRequest']
        ]
    ]
];
?>
