<?php

namespace zikwall\easyonline\assets;

use Yii;
use yii\web\AssetBundle;

class JqueryTimeAgoLocaleAsset extends AssetBundle
{

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/jquery-timeago';

    /**
     * @var array language mapping between encore locale id and timeago messages
     */
    public $languageMapping = [
        'nb_no' => 'no',
        'pt_br' => 'pt-br',
        'zh_cn' => 'zh-CN',
        'zh_tw' => 'zh-TW',
        'fa_ir' => 'fa',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerLocale();
    }

    /**
     * Adds the correct locale file to js files
     */
    protected function registerLocale()
    {
        $languageCode = Yii::$app->language;

        if (array_key_exists($languageCode, $this->languageMapping)) {
            $languageCode = $this->languageMapping[$languageCode];
        }

        $localeFile = 'locales' . DIRECTORY_SEPARATOR . 'jquery.timeago.' . $languageCode . '.js';
        if (file_exists(Yii::getAlias($this->sourcePath . '/' . $localeFile))) {
            $this->js[] = $localeFile;
        }
    }

}
