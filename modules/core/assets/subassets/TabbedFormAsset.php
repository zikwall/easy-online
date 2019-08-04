<?php

namespace zikwall\easyonline\modules\core\assets\subassets;

use yii\web\AssetBundle;

/**
 * tabbed form asset
 *
 * @author buddha
 */
class TabbedFormAsset extends AssetBundle
{

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    /**
     * @inheritdoc
     */
    public $basePath = '@webroot';

    /**
     * @inheritdoc
     */
    public $sourcePath = '@webroot/resources';

    public $baseUrl = '@web/resources';

    /**
     * @inheritdoc
     */
    public $js = ['js/encore.ui.form.js'];

}
