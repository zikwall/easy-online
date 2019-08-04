<?php

namespace zikwall\easyonline\modules\admin\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{

    public $sourcePath = '@admin/resources';
    public $css = [];
    public $js = [
        'js/encore.admin.js',
        'js/encore.admin.group.js'
    ];

}
