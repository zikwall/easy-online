<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use yii\web\AssetBundle;

class JqueryCookieAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery.cookie';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.cookie.js'];

}
