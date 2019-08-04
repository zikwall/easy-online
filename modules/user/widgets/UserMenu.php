<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use zikwall\easyonline\modules\user\models\UserApprovalSearch;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\permissions\ManageUsers;

class UserMenu extends BaseMenu
{

    public $template = "@admin/widgets/views/tabMenu";
    public $type = "adminUserSubNavigation";

    public function init()
    {
        $this->addItem([
            'label' => Yii::t('AdminModule.views_user_index', 'Users'),
            'url' => Url::to(['/user/admin/index']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'user'),
            'isVisible' => Yii::$app->user->can([
                new ManageUsers(),
                new ManageGroups(),
            ])
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.views_user_index', 'Settings'),
            'url' => Url::to(['/user/authentication']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'authentication'),
            'isVisible' => Yii::$app->user->can([
                new ManageSettings()
            ])
        ]);

        $approvalCount = UserApprovalSearch::getUserApprovalCount();
        if ($approvalCount > 0) {
            $this->addItem([
                'label' => Yii::t('AdminModule.user', 'Pending approvals') . ' <span class="label label-danger">' . $approvalCount . '</span>',
                'url' => Url::to(['/user/approval']),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'approval'),
                'isVisible' => Yii::$app->user->can([
                    new ManageUsers(),
                    new ManageGroups()
                ])
            ]);
        }

        $this->addItem([
            'label' => Yii::t('AdminModule.user', 'Profiles'),
            'url' => Url::to(['/user/user-profile']),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'user-profile'),
            'isVisible' => Yii::$app->user->can([
                new ManageUsers()
            ])
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.user', 'Groups'),
            'url' => Url::to(['/user/group']),
            'sortOrder' => 500,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'group'),
            'isVisible' => Yii::$app->user->can(
                    new ManageGroups()
            )
        ]);

        parent::init();
    }

}
