<?php

namespace zikwall\easyonline\modules\admin\assets;

use yii\web\AssetBundle;

class AdminGroupAsset extends AssetBundle
{

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $sourcePath = '@admin/resources';
    public $css = [];
    public $js = [
        'js/encore.admin.group.js'
    ];

}
