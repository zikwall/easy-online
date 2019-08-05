# easy-online

## Installation

##### Pre-Setup configure composer.json (https://github.com/zikwall/easy-online-composer)

##### Change index file (web/index.php)

```php

// for example Yii2 basic app
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../config/web.php',
    require __DIR__ . '/../vendor/zikwall/easy-online/modules/core/config/web.php',
    (is_readable(__DIR__ . '/../config/easy-online-dynamic.php'))
        ? require(__DIR__ . '/../config/easy-online-dynamic.php')
        : []
);

(function ($config) {
    (new \zikwall\easyonline\modules\core\components\web\Application($config))->run();
})($config);

```

##### Open site in browser to start the installation process

Visit: http://c95202tj.bget.ru to view example

You can Signup (also through social OAuth 🎁) or enter right away:

1. __Login__: _Username_
2. __Password__: _123456_

❌ it does not provide access to the admin panel!
