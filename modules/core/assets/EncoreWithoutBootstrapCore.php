<?php

namespace zikwall\easyonline\modules\core\assets;

use yii\web\AssetBundle;

class EncoreWithoutBootstrapCore extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $basePath = '@zikwall/easyonline/modules/core/web';

    /**
     * @inheritdoc
     */
    public $sourcePath = '@zikwall/easyonline/modules/core/web/resources';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/animate.min.css',
        'css/spiner.css'
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/legacy/jquery.loader.js',
        'js/encore.core.js',
        'js/encore.util.js',
        'js/encore.log.js',
        //'js/encore.ui.view.js',
        'js/encore.ui.additions.js',
        'js/encore.ui.loader.js',
        'js/encore.action.js',
        'js/encore.ui.widget.js',
        'js/encore.ui.modal.js',
        'js/encore.client.js',
        'js/encore.ui.status.js',
        //'js/encore.ui.navigation.js',
        //'js/encore.ui.richtext.js',
    ];

    // clear bootstrap bundles
    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'css' => [],
            'js' => []
        ];
    }
}
