<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use yii\web\AssetBundle;

class JqueryAutosizeAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/autosize';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.autosize.min.js'];

    /**
     * @inheritdoc
     */
    public $css = [];

}
