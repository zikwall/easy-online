<?php

namespace zikwall\easyonline\modules\ui\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\components\User;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\admin\widgets\AdminMenu;

class SidebarUserMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/themes/core/views/ui/widgets/sidebarUserMenu";

    /**
     * @inheritdoc
     */
    public $type = 'user-sidebar';

    /**
     * @inheritdoc
     */
    public $id = 'user-side-menu-nav';

    public function init()
    {
        parent::init();

        $this->addItem([
            'label' => 'Центр профориентации',
            'url' => Url::to(['/default']),
            'sortOrder' => 100,
        ]);

        if (Yii::$app->user->isGuest && !User::isGuestAccessEnabled()) {
            $this->template = '';

            return false;
        }

        return parent::run();
    }
}
