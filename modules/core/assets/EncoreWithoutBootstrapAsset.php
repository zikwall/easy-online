<?php

namespace zikwall\easyonline\modules\core\assets;

use yii\web\AssetBundle;
use zikwall\easyonline\modules\admin\assets\AdminAsset;

class EncoreWithoutBootstrapAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
        'zikwall\easyonline\modules\core\assets\EncoreWithoutBootstrapCore',
        'zikwall\easyonline\modules\core\assets\jquery\JqueryWidgetAsset',
        'zikwall\easyonline\modules\core\assets\jquery\JqueryTimeAgoAsset',
        'zikwall\easyonline\modules\content\assets\ContentContainerAsset',
        'zikwall\easyonline\modules\admin\assets\AdminAsset',
        'zikwall\easyonline\modules\user\assets\UserAsset',
        'zikwall\easyonline\modules\community\assets\CommunityAsset',
        //'zikwall\easyonline\modules\user\assets\UserPickerAsset',
        //'zikwall\easyonline\modules\user\assets\User',
        'zikwall\easyonline\modules\core\assets\bootstrap\Select2BootstrapAsset',
    ];
}
