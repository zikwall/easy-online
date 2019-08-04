<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\permissions\ViewAboutPage;

/**
 * ProfileMenuWidget shows the (usually left) navigation on user profiles.
 *
 * Only a controller which uses the 'application.modules_core.user.ProfileControllerBehavior'
 * can use this widget.
 *
 * The current user can be gathered via:
 *  $user = Yii::$app->getController()->getUser();
 *
 */
class ProfileMenu extends BaseMenu
{

    /**
     * @var User
     */
    public $user;

    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/modules/core/widgets/views/leftNavigation";

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItemGroup([
            'id' => 'profile',
            'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', '<strong>Profile</strong> menu'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', 'Stream'),
            'group' => 'profile',
            //'icon' => '<i class="fa fa-bars"></i>',
            'url' => $this->user->createUrl('//user/profile/home'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->id == "profile" && (Yii::$app->controller->action->id == "index" || Yii::$app->controller->action->id == "home")),
        ]);

        if ($this->user->permissionManager->can(new ViewAboutPage())) {
            $this->addItem([
                'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', 'About'),
                'group' => 'profile',
                //'icon' => '<i class="fa fa-info-circle"></i>',
                'url' => $this->user->createUrl('//user/profile/about'),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->id == "profile" && Yii::$app->controller->action->id == "about"),
            ]);
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->user->isGuest && $this->user->visibility != User::VISIBILITY_ALL) {
            return;
        }

        return parent::run();
    }

}

?>
