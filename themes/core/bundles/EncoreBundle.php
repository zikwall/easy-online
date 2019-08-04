<?php

namespace zikwall\easyonline\themes\core\bundles;

use yii\web\AssetBundle;

class EncoreBundle extends AssetBundle
{
    public $sourcePath = '@zikwall/easyonline/themes/core/assets';

    public $css = [
        'https://fonts.googleapis.com/css?family=PT+Sans',
        'https://fonts.googleapis.com/css?family=Jura',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css',
        'css/bootstrap.min.css',
        'css/bootstrap-customize.css',
        'overlay/css/OverlayScrollbars.css',
        'overlay/themes/os-theme-thin-dark.css',

        'css/components/icon/base.css',
        'css/components/tab/tab.css',
        'css/components/grid/column.css',
        'css/components/divider/base.css',
        'css/components/sidebar/base.css',
        'css/components/blockquote/base.css',

        'css/components/panel/base.css',
        'css/components/panel/module.css',
        'css/components/panel/blog.css',
        'css/components/panel/group.css',
        'css/components/panel/list-group.css',

        'css/components/modal/base.css',
        'css/components/button/button.css',
        'css/components/menu/action.css',
        'css/components/search/results.css',
        'css/components/search/input.css',
        'css/components/header/profile.css',

        'css/components/user/online.css',
        'css/components/user/profile.css',
        'css/components/user/page/avatar.css',
        'css/components/user/page/info.css',
        'css/components/user/page/gifts.css',
        'css/components/user/page/structure.css',
        'css/components/user/authchoise.css',
        'css/components/user/login.css',
        'css/components/user/error.css',

        'css/components/community/header.css',
        'css/components/community/members.css',
        'css/components/community/information.css',

        'css/components/app/catalog.css',

        'css/en-core.css',
        'css/base.css',
    ];

    public $js = [
        //'js/jquery.min.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.js',
        'js/bootstrap.bundle.js',
        'js/custom.js',
        'js/sticky.js',
        'ns/ns.js',
        'overlay/js/OverlayScrollbars.js',

        'js/components/user/authchoise.js',
    ];

    public $depends = [
        'zikwall\easyonline\modules\core\assets\EncoreWithoutBootstrapAsset'
    ];
}
