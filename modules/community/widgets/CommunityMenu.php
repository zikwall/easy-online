<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\community\permissions\ManageCommunity;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class CommunityMenu extends BaseMenu
{
    public $template = "@ui/widgets/views/tabMenu";
    public $type = "adminUserSubNavigation";

    public function init()
    {
        $this->addItem([
            'label' => Yii::t('AdminModule.views_space_index', 'Communities'),
            'url' => Url::toRoute(['/community/admin/index']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'community' && Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'index'),
            'isVisible' => Yii::$app->user->can(new ManageCommunity())
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.views_space_index', 'Settings'),
            'url' => Url::toRoute(['/community/admin/settings']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'community' && Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'settings'),
            'isVisible' => Yii::$app->user->can(new ManageSettings())
        ]);

        parent::init();
    }

}
