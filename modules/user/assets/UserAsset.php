<?php

namespace zikwall\easyonline\modules\user\assets;

use yii\web\AssetBundle;
class UserAsset extends AssetBundle
{
    public $sourcePath = '@user/resources';
    public $css = [];
    public $js = [
        'js/encore.user.js',
    ];

    public $depends = [
        'zikwall\easyonline\modules\core\assets\EncoreWithoutBootstrapCore',
    ];
}
