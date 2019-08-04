<?php

namespace zikwall\easyonline\modules\community\modules\manage\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class DefaultMenu extends BaseMenu
{
    public $template = "@core/widgets/views/tabMenu";

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    public function init()
    {
        $this->addItem(array(
            'label' => Yii::t('AdminModule.manage', 'Basic'),
            'url' => $this->community->createUrl('/community/manage/default/index'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'index'),
        ));
        $this->addItem(array(
            'label' => Yii::t('AdminModule.manage', 'Advanced'),
            'url' => $this->community->createUrl('/community/manage/default/advanced'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->id == 'default' && Yii::$app->controller->action->id == 'advanced'),
        ));
        parent::init();
    }

}
