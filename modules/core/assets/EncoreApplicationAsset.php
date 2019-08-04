<?php

namespace zikwall\easyonline\modules\core\assets;

use yii\web\AssetBundle;

class EncoreApplicationAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
        /*'zikwall\easyonline\modules\core\assets\AnimateCssAsset',*/
        'zikwall\easyonline\modules\core\assets\EncoreCoreAssetBundle',
        'zikwall\easyonline\modules\core\assets\jquery\JqueryTimeAgoAsset',
        'zikwall\easyonline\modules\content\assets\ContentContainerAsset',
        'zikwall\easyonline\modules\user\assets\UserAsset',
    ];
}
