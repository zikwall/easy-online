<?php

namespace zikwall\easyonline\modules\core\assets\jquery;

use Yii;
use yii\web\AssetBundle;

class JqueryTimeAgoAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-timeago';

    /**
     * @inheritdoc
     */
    public $js = ['jquery.timeago.js'];

}
