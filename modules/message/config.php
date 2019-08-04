<?php

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\widgets\ProfileHeaderControls;
use zikwall\easyonline\modules\ui\widgets\SidebarMenu;

return [
    'id' => 'message',
    'class' => 'zikwall\easyonline\modules\message\Module',
    'namespace' => 'zikwall\easyonline\modules\message',
    'events' => [
        ['class' => User::className(), 'event' => User::EVENT_BEFORE_DELETE, 'callback' => ['zikwall\easyonline\modules\message\Events', 'onUserDelete']],
        [
            'class' => SidebarMenu::className(),
            'event' => SidebarMenu::EVENT_INIT,
            'callback' => ['zikwall\easyonline\modules\message\Events', 'onSidebarMenuInit']
        ],
        //['class' => NotificationArea::className(), 'event' => NotificationArea::EVENT_INIT, 'callback' => ['zikwall\easyonline\modules\message\Events', 'onNotificationAddonInit']],
        ['class' => ProfileHeaderControls::className(), 'event' => ProfileHeaderControls::EVENT_INIT, 'callback' => ['zikwall\easyonline\modules\message\Events', 'onProfileHeaderControlsInit']],
    ],
];
?>
