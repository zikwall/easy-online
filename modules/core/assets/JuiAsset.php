<?php

namespace zikwall\easyonline\modules\core\assets;

use yii\web\AssetBundle;


class JuiAsset extends AssetBundle
{

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

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
    public $js = [];

    public $depends = [
        'yii\jui\JuiAsset'
    ];

}
