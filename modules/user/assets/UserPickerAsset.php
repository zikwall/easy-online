<?php

namespace zikwall\easyonline\modules\user\assets;

use yii\web\AssetBundle;

class UserPickerAsset extends AssetBundle
{
    public $sourcePath = '@user/resources';
    public $css = [];
    public $js = [
        'js/encore.user.picker.js',
    ];

    public $depends = [
        'zikwall\easyonline\modules\core\assets\bootstrap\Select2BootstrapAsset'
    ];

}
