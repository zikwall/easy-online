<?php

namespace zikwall\easyonline\modules\user\widgets;

use zikwall\easyonline\modules\core\widgets\BaseMenu;
use Yii;
use yii\helpers\Url;

/**
 * Community Administration Menu
 */
class GroupManagerMenu extends BaseMenu
{

    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/modules/core/widgets/views/tabMenu";

    /**
     * @var \zikwall\easyonline\modules\user\models\Group
     */
    public $group;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItem([
            'label' => Yii::t('AdminModule.views_user_index', 'Settings'),
            'url' => Url::toRoute(['/user/group/edit', 'id' => $this->group->id]),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'group' && Yii::$app->controller->action->id == 'edit'),
        ]);
        $this->addItem([
            'label' => Yii::t('AdminModule.views_groups_index', "Permissions"),
            'url' => Url::toRoute(['/user/group/manage-permissions', 'id' => $this->group->id]),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'group' && Yii::$app->controller->action->id == 'manage-permissions'),
        ]);
        $this->addItem([
            'label' => Yii::t('AdminModule.views_groups_index', "Members"),
            'url' => Url::toRoute(['/user/group/manage-group-users', 'id' => $this->group->id]),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'group' && Yii::$app->controller->action->id == 'manage-group-users'),
        ]);

        parent::init();
    }

}
