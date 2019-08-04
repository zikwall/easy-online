<?php

namespace zikwall\easyonline\modules\community\modules\manage\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;


class SecurityTabMenu extends BaseMenu
{
    public $template = "@core/widgets/views/tabMenu";

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    public function init()
    {
        $this->addItem(array(
            'label' => Yii::t('AdminModule.manage', 'General'),
            'url' => $this->community->createUrl('/community/manage/security'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->id == 'security' && Yii::$app->controller->action->id == 'index'),
        ));
        $this->addItem(array(
            'label' => Yii::t('AdminModule.manage', 'Permissions'),
            'url' => $this->community->createUrl('/community/manage/security/permissions'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->id == 'security' && Yii::$app->controller->action->id == 'permissions'),
        ));
        parent::init();
    }
}
