<?php

namespace zikwall\easyonline\modules\core\assets\bootstrap;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/fontawesome';

    /**
     * @inheritdoc
     */
    public $css = ['web-fonts-with-css/css/fontawesome-all.css'];

}
