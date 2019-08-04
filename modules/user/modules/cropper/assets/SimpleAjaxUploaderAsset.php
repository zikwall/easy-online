<?php

namespace zikwall\easyonline\modules\user\modules\cropper\assets;

use yii\web\AssetBundle;

class SimpleAjaxUploaderAsset extends AssetBundle
{
    public $sourcePath = '@bower/simple-ajax-uploader/';

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $js = [
        'SimpleAjaxUploader.min.js'
    ];
}
