<?php

namespace zikwall\easyonline\modules\community\assets;

use yii\web\AssetBundle;

class CommunityChooserAsset extends AssetBundle
{
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $sourcePath = '@community/resources';
    public $css = [];
    public $js = [
        'js/encore.community.chooser.js'
    ];

    public $depends = ['zikwall\easyonline\modules\community\assets\CommunityAsset'];
}
