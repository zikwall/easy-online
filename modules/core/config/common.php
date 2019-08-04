<?php
return [
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'zikwall\easyonline\modules\core\migrations',
            ],
        ],
    ],
];
