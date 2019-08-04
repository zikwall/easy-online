<?php

namespace zikwall\easyonline\modules\user\modules\cropper\assets;

use yii\web\AssetBundle;

class JcropAsset extends AssetBundle
{
    public $sourcePath = '@bower/jcrop/';

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $js = [
        'js/jquery.Jcrop.min.js'
    ];

    public $css = [
        'css/jquery.Jcrop.min.css'
    ];
}
