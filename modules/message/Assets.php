<?php

namespace zikwall\easyonline\modules\message;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $css = [
        'mail.css',
    ];
    public $js = [
        'mail.js'
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }
}
