<?php

namespace zikwall\easyonline\modules\community\assets;

use yii\web\AssetBundle;

class CommunityAsset extends AssetBundle
{
    public $sourcePath = '@community/resources';
    public $css = [];
    public $js = [
        'js/encore.community.js'
    ];
}
