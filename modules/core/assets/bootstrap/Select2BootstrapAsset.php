<?php

namespace zikwall\easyonline\modules\core\assets\bootstrap;

use yii\web\AssetBundle;

class Select2BootstrapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@core/web/resources';

    public $css = ['css/select2Theme/select2-encore.css'];

    /**
     * @var array
     */
    public $depends = [
        'zikwall\easyonline\modules\core\assets\bootstrap\Select2Asset'
    ];

}
