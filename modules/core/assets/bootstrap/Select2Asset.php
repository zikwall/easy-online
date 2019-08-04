<?php

namespace zikwall\easyonline\modules\core\assets\bootstrap;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/select2';

    /**
     * @inheritdoc
     */
    public $js = ['dist/js/select2.full.js'];

    /**
     * @inheritdoc
     */
    public $css = ['dist/css/select2.min.css'];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset'
    ];

}
