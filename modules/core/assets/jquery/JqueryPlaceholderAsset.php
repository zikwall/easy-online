<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use yii\web\AssetBundle;

class JqueryPlaceholderAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-placeholder';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.placeholder.min.js'];

}
