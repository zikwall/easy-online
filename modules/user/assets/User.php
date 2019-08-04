<?php

namespace zikwall\easyonline\modules\user\assets;

use yii\web\AssetBundle;

class User extends AssetBundle
{
    public $sourcePath = '@user/resources';

    public $css = [];
    public $js = [
        'js/encore.user.picker.js',
        'js/userPicker.js'
    ];
}
