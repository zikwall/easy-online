<?php


namespace zikwall\easyonline\modules\community\modules\manage\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class SecurityTabSubMenu extends BaseMenu
{
    public $template = "@core/widgets/views/tabMenu";

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    public $groups = [];
    public $groupId;

    public function init()
    {
        $i = 10;

        foreach ($this->groups as $currentGroupId => $groupLabel) {
            $this->addItem([
                'label' => $groupLabel,
                'url' => $this->community->createUrl('permissions', ['groupId' => $currentGroupId]),
                'sortOrder' => 100 + $i++,
                'isActive' => $this->groupId === $currentGroupId,
            ]);
        }

        parent::init();
    }
}
