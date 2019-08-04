<?php

namespace zikwall\easyonline\modules\ui\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\components\User;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\admin\widgets\AdminMenu;
use zikwall\easyonline\modules\user\models\forms\Login;

class SidebarMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/themes/core/views/ui/widgets/sidebarMenu";

    /**
     * @inheritdoc
     */
    public $type = 'sidebar';

    /**
     * @inheritdoc
     */
    public $id = 'side-menu-nav';

    /**
     * @var Login
     */
    public $login;

    public function init()
    {
        parent::init();

        $this->enableIcons = false;

        if (Yii::$app->user->isGuest) {
            if (!User::isGuestAccessEnabled()) {
                $this->template = '';
            }

            // Обработка формы входа в систему
            $this->login = new Login();
            $this->advancedParams['loginForm'] = $this->login;

            return false;
        }

        return parent::run();
    }

    public function run()
    {
        if (!$this->ifAllowControllers()) {
            return false;
        }

        /**
         * TODO template login here
         */

        return parent::run();
    }

    public function ifAllowControllers()
    {
        if (Yii::$app->getModule('ui')->getEnabledSidebar() === false) {
            return false;
        }

        $controller = Yii::$app->controller;
        $module = $controller->module;

        if ($module->id == 'core') {
            if ($controller->id == 'default' && $controller->action->id == 'terms') {
                return false;
            }
        }

        return true;
    }
}
