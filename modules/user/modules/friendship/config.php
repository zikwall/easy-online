<?php

use zikwall\easyonline\modules\user\modules\friendship\Events;
use zikwall\easyonline\modules\user\modules\user\widgets\AccountMenu;

return [
    'id' => 'friendship',
    'class' => \zikwall\easyonline\modules\user\modules\friendship\Module::class,
    'isCoreModule' => true,
    'events' => [
        /*[
            'class' => AccountMenu::class,
            'event' => AccountMenu::EVENT_INIT,
            'callback' => array(Events::class, 'onAccountMenuInit')
        ],*/
    ]
];
?>
