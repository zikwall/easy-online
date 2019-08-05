<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'installed' => false,
    'databaseInstalled' => false,
    'dynamicConfigFile' => '@app/config/easy-online-dynamic.php',
    'moduleAutoloadPaths' => ['@app/modules', '@zikwall/easy-online/modules'],
    'moduleCustomPath' => '@app/modules',
    'enablePjax' => false,
    'availableLanguages' => [
        'en' => 'English (US)',
        'en_gb' => 'English (UK)',
        'de' => 'Deutsch',
        'fr' => 'Français',
        'nl' => 'Nederlands',
        'pl' => 'Polski',
        'pt' => 'Português',
        'pt_br' => 'Português do Brasil',
        'es' => 'Español',
        'ca' => 'Català',
        'it' => 'Italiano',
        'th' => 'ไทย',
        'tr' => 'Türkçe',
        'ru' => 'Русский',
        'uk' => 'українська',
    ],
    'allowedLanguages' => [],
    'defaultPermissions' => [],
    'easyonline' => [
        'apiEnabled' => false
    ]
];
