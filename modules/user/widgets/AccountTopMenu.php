<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\admin\widgets\AdminMenu;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\user\models\User;

class AccountTopMenu extends BaseMenu
{
    /**
     * @var boolean show user name
     */
    public $showUserName = true;

    /**
     * @inheritdoc
     */
    public $template = "accountTopMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        /**
         * @var $user User
         */
        $user = Yii::$app->user->getIdentity();

        $this->addItem([
            'label' => Yii::t('base', 'My profile'),
            //'icon' => '<i class="fa fa-user"></i>',
            'url' => $user->createUrl('/user/profile/home'),
            'sortOrder' => 100,
        ]);
        $this->addItem([
            'label' => Yii::t('base', 'Account settings'),
            //'icon' => '<i class="fa fa-edit"></i>',
            'url' => Url::toRoute('/user/account/edit'),
            'sortOrder' => 200,
        ]);

        if (AdminMenu::canAccess()) {
            if (Yii::$app->user->isAdmin()) {
                $this->addItem([
                    'label' => '---',
                    'url' => '#',
                    'sortOrder' => 300,
                ]);

                $this->addItem([
                    'label' => Yii::t('base', 'Administration'),
                    //'icon' => '<i class="fa fa-cogs"></i>',
                    'url' => Url::toRoute('/admin/index'),
                    'sortOrder' => 400,
                ]);
            }
        }

        $this->addItem([
            'label' => '---',
            'url' => '#',
            'sortOrder' => 600,
        ]);

        $this->addItem([
            'label' => Yii::t('base', 'Logout'),
            'id' => 'account-logout',
            //'icon' => '<i class="fa fa-sign-out"></i>',
            'pjax' => false,
            'url' => Url::toRoute('/user/auth/logout'),
            'sortOrder' => 700,
        ]);

        parent::init();
    }

}
