<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use yii\web\AssetBundle;

class JqueryColorAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-color';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.color.js'];

    /**
     * @inheritdoc
     */
    public $css = [];

}
