<?php

namespace zikwall\easyonline\modules\admin\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\admin\permissions\ManageModules;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\admin\permissions\SeeAdminInformation;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\permissions\ManageUsers;

class AdminMenu extends BaseMenu
{

    public $template = "@zikwall/easyonline/modules/core/widgets/views/leftNavigation";
    public $type = "adminNavigation";
    public $id = "admin-menu";

    public $outerWrapper = true;
    public $outerWrapperOptions = [
        'id' => 'adminsidebar'
    ];

    public function init()
    {
        $this->addItemGroup([
            'id' => 'admin',
            'label' => \Yii::t('AdminModule.widgets_AdminMenuWidget', '<strong>Administration</strong> menu'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => \Yii::t('AdminModule.widgets_AdminMenuWidget', 'Users'),
            'url' => Url::toRoute(['/user/admin']),
            //'icon' => '<i class="fa fa-user"></i>',
            'sortOrder' => 200,
            'isActive' => (\Yii::$app->controller->module && \Yii::$app->controller->module->id == 'user' && (Yii::$app->controller->id == 'admin' || Yii::$app->controller->id == 'group' || Yii::$app->controller->id == 'approval' || Yii::$app->controller->id == 'authentication' || Yii::$app->controller->id == 'user-profile')),
            'isVisible' => Yii::$app->user->can([
                new ManageUsers(),
                new ManageSettings(),
                new ManageGroups()
            ]),
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Modules'),
            'id' => 'modules',
            'url' => Url::toRoute('/admin/module'),
            //'icon' => '<i class="fa fa-rocket"></i>',
            'sortOrder' => 500,
            'newItemCount' => 0,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'module'),
            'isVisible' => Yii::$app->user->can(new ManageModules())
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Settings'),
            'url' => Url::toRoute('/admin/setting'),
            //'icon' => '<i class="fa fa-gears"></i>',
            'sortOrder' => 600,
            'newItemCount' => 0,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'setting'),
            'isVisible' => Yii::$app->user->can(new ManageSettings())
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Information'),
            'url' => Url::toRoute('/admin/information'),
            //'icon' => '<i class="fa fa-info-circle"></i>',
            'sortOrder' => 10000,
            'newItemCount' => 0,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'information'),
            'isVisible' => Yii::$app->user->can(new SeeAdminInformation())
        ]);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Workaround for modules with no admin menu permission support.
        if (!Yii::$app->user->isAdmin()) {
            foreach ($this->items as $key => $item) {
                if (!isset($item['isVisible'])) {
                    unset($this->items[$key]);
                }
            }
        }

        return parent::run();
    }

    public function addItem(array $item) : void
    {
        $item['group'] = 'admin';

        parent::addItem($item);
    }

    public static function canAccess()
    {
        $canSeeAdminSection = Yii::$app->session->get('user.canSeeAdminSection');
        if ($canSeeAdminSection == null) {
            $canSeeAdminSection = Yii::$app->user->isAdmin() ? true : self::checkNonAdminAccess();
            Yii::$app->session->set('user.canSeeAdminSection', $canSeeAdminSection);
        }

		return $canSeeAdminSection;
    }

    private static function checkNonAdminAccess()
    {
        $adminMenu = new self();
        foreach($adminMenu->items as $item) {
            if (isset($item['isVisible']) && $item['isVisible']) {
                return true;
            }
        }

		return false;
    }

}
