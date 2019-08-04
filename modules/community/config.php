<?php

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\Events;
use zikwall\easyonline\modules\core\components\console\Application;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\community\models\Community;

return [
    'id' => 'community',
    'class' => \zikwall\easyonline\modules\community\Module::class,
    'isCoreModule' => true,
    'urlManagerRules' => [
        ['class' => 'zikwall\easyonline\modules\community\components\UrlRule'],
    ],
    'modules' => [
        'manage' => [
            'class' => 'zikwall\easyonline\modules\community\modules\manage\Module'
        ],
    ],
    'events' => [
        [
            'class' => User::class,
            'event' => User::EVENT_BEFORE_DELETE,
            'callback' => [Events::class, 'onUserDelete']
        ],
        [
            'class' => Application::class,
            'event' => Application::EVENT_ON_INIT,
            'callback' => [Events::class, 'onConsoleApplicationInit']
        ],
        [
            'class' => \zikwall\easyonline\modules\admin\widgets\AdminMenu::class,
            'event' => \zikwall\easyonline\modules\admin\widgets\AdminMenu::EVENT_INIT,
            'callback' => [
                'zikwall\easyonline\modules\community\Events',
                'onAdminMenuInit'
            ],
        ],

        // Community Type
        [
            'class' => 'zikwall\easyonline\modules\community\widgets\CommunityMenu',
            'event' => BaseMenu::EVENT_INIT,
            'callback' => ['zikwall\easyonline\modules\community\Events', 'onAdminCommunityMenuInit']],
        [
            'class' => 'zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu',
            'event' => BaseMenu::EVENT_INIT,
            'callback' => ['zikwall\easyonline\modules\community\Events', 'onCommunityAdminDefaultMenuInit']
        ],
        [
            'class' => 'zikwall\easyonline\modules\community\models\Community',
            'event' => Community::EVENT_BEFORE_INSERT,
            'callback' => ['zikwall\easyonline\modules\community\Events', 'onCommunityBeforeInsert']
        ],
    ],
];
?>
