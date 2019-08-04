<?php

namespace zikwall\easyonline\modules\admin\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class AdminModuleTabsWidget extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/modules/core/widgets/views/tabMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItem([
            'label' => 'Установленные',
            'url' => Url::to('/admin/module/list'),
            'icon' => '<i class="material-icons">extension</i>',
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'module' && (Yii::$app->controller->action->id == 'list' || Yii::$app->controller->action->id == 'index')),
        ]);

        $this->addItem([
            'label' => 'Маркетплейс',
            'url' => Url::to('/admin/module/online'),
            'icon' => '<i class="material-icons">backup</i>',
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'university' && Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'settings'),
        ]);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return parent::run();
    }
}
