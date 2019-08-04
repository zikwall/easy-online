<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use yii\web\AssetBundle;

class JqueryHighlightAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot-static';

    /**
     * @inheritdoc
     */
    public $baseUrl = '@web-static';

    /**
     * @inheritdoc
     */
    public $js = ['js/jquery.highlight.min.js'];

}
