<?php

namespace zikwall\easyonline\modules\content\assets;

use yii\web\AssetBundle;

class ContentContainerAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@content/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/encore.content.container.js'
    ];

}
