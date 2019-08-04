<?php
namespace zikwall\easyonline\modules\message\assets;

use yii\helpers\Url;
use yii\web\AssetBundle;

class MailAsset extends AssetBundle
{
    public $publishOptions = [
        'forceCopy' => false
    ];

    public $sourcePath = '@mail/resources';

    public $js = [
        'js/encore.mail.wall.js',
        'js/encore.mail.js'
    ];

    public $css = ['css/encore.mail.css'];

    public static function register($view)
    {
        $view->registerJsConfig([
            'mail' => [
                'url' => [
                    'count' => Url::to(['/mail/mail/get-new-message-count-json']),
                    'list' => Url::to(['/mail/mail/notification-list']),
                ]
            ],
            'mail.wall' => [
                'url' => [
                    'seen' => Url::to(['/mail/mail/seen'])
                ]
            ]
        ]);

        return parent::register($view);
    }


}
