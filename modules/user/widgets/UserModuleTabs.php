<?php
namespace zikwall\easyonline\modules\user\widgets;

use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\permissions\ManageUsers;
use Yii;
use yii\helpers\Url;

class UserModuleTabs extends \zikwall\easyonline\modules\core\widgets\BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/modules/ui/widgets/views/tabMenu";

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItem([
            'label' => 'Пользователи',
            'url' => Url::to('/user/admin'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user'
                && (Yii::$app->controller->id == 'admin')),
            'isVisible' => Yii::$app->user->can([
                new ManageUsers(),
                new ManageGroups(),
            ])
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.views_user_index', 'Settings'),
            'url' => Url::to(['/user/authentication']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'authentication'),
            'isVisible' => Yii::$app->user->can([
                new ManageSettings()
            ])
        ]);

        $approvalCount = \zikwall\easyonline\modules\user\models\UserApprovalSearch::getUserApprovalCount();
        if ($approvalCount > 0) {
            $this->addItem([
                'label' => Yii::t('AdminModule.user', 'Pending approvals') . ' <span class="label label-danger">' . $approvalCount . '</span>',
                'url' => Url::to(['/user/approval']),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'approval'),
                'isVisible' => Yii::$app->user->can([
                    new ManageUsers(),
                    new ManageGroups(),
                ])
            ]);
        }

        $this->addItem([
            'label' => Yii::t('AdminModule.user', 'Profiles'),
            'url' => Url::to(['/user/user-profile']),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'user-profile'),
            'isVisible' => Yii::$app->user->can([
                new ManageUsers()
            ])
        ]);

        $this->addItem([
            'label' => 'Группы',
            'url' => Url::to('/user/group'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'group'),
            'isVisible' => Yii::$app->user->can(
                new ManageGroups()
            )
        ]);

        $this->addItem([
            'label' => 'Контроль доступа',
            'url' => Url::to('/user/rbac'),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'user' && Yii::$app->controller->id == 'rbac'),
            'isVisible' => Yii::$app->user->can(new ManageSettings()),
        ]);

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return parent::run();
    }
}
