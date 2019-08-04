<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use \yii\helpers\Url;

class AccountMenu extends \zikwall\easyonline\modules\core\widgets\BaseMenu
{

    public $template = "@zikwall/easyonline/modules/core/widgets/views/leftNavigation";
    public $type = "accountNavigation";

    public function init()
    {
        $user = Yii::$app->user->getIdentity();

        $controllerAction = Yii::$app->controller->action->id;
        $this->addItemGroup([
            'id' => 'account',
            'label' => Yii::t('UserModule.widgets_AccountMenuWidget', '<strong>Account</strong> settings'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => $user->getDisplayName(),
            'isOwnblock' => true,
            'group' => 'account',
            'url' => $user->createUrl('/user/profile/home'),
            'sortOrder' => 100,
            'hint' => 'вернуться к профилю'
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.widgets_AccountMenuWidget', 'Profile'),
            //'icon' => '<i class="fa fa-user"></i>',
            'group' => 'account',
            'url' => Url::toRoute('/user/account/edit'),
            'sortOrder' => 200,
            'isActive' => ($controllerAction == "edit" || $controllerAction == "change-email" || $controllerAction == "change-password" || $controllerAction == "delete"),
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.account', 'E-Mail Summaries'),
            //'icon' => '<i class="fa fa-envelope"></i>',
            'group' => 'account',
            'url' => Url::toRoute('/activity/user'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module->id == 'activity'),
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.account', 'Notifications'),
            //'icon' => '<i class="fa fa-bell"></i>',
            'group' => 'account',
            'url' => Url::toRoute('/notification/user'),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module->id == 'notification'),
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.widgets_AccountMenuWidget', 'Settings'),
            //'icon' => '<i class="fa fa-wrench"></i>',
            'group' => 'account',
            'url' => Url::toRoute('/user/account/edit-settings'),
            'sortOrder' => 500,
            'isActive' => ($controllerAction == "edit-settings"),
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.widgets_AccountMenuWidget', 'Security'),
            //'icon' => '<i class="fa fa-lock"></i>',
            'group' => 'account',
            'url' => Url::toRoute('/user/account/security'),
            'sortOrder' => 600,
            'isActive' => (Yii::$app->controller->action->id == "security"),
        ]);

        // Only show this page when really user specific modules available
        if (count($user->getAvailableModules()) != 0) {
            $this->addItem([
                'label' => Yii::t('UserModule.widgets_AccountMenuWidget', 'Modules'),
                //'icon' => '<i class="fa fa-rocket"></i>',
                'group' => 'account',
                'url' => Url::toRoute('//user/account/edit-modules'),
                'sortOrder' => 700,
                'isActive' => (Yii::$app->controller->action->id == "edit-modules"),
            ]);
        }

        parent::init();
    }

}

?>
