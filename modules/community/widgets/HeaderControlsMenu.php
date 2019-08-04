<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class HeaderControlsMenu extends BaseMenu
{
    public $community;
    public $template = "@ui/widgets/views/dropDownMenuControls";

    public function init()
    {
        $this->addItemGroup([
            'id' => 'admin',
            'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', '<i class="fa fa-cog"></i>'),
            'sortOrder' => 100,
        ]);

        // check user rights
        if ($this->community->isAdmin()) {

            $this->addItem([
                'label' => Yii::t('CommunityModule.base', 'Settings'),
                'group' => 'admin',
                'url' => $this->community->createUrl('/community/manage'),
                'icon' => '<i class="fa fa-cogs"></i>',
                'sortOrder' => 100,
                'isActive' => (Yii::$app->controller->id == "default"),
            ]);

            $this->addItem([
                'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Security'),
                'group' => 'admin',
                'url' => $this->community->createUrl('/community/manage/security'),
                'icon' => '<i class="fa fa-lock"></i>',
                'sortOrder' => 200,
                'isActive' => (Yii::$app->controller->id == "security"),
            ]);

            $this->addItem([
                'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Members'),
                'group' => 'admin',
                'url' => $this->community->createUrl('/community/manage/member'),
                'icon' => '<i class="fa fa-group"></i>',
                'sortOrder' => 200,
                'isActive' => (Yii::$app->controller->id == "member"),
            ]);

            $this->addItem([
                'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Modules'),
                'group' => 'admin',
                'url' => $this->community->createUrl('/community/manage/module'),
                'icon' => '<i class="fa fa-rocket"></i>',
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->id == "module"),
            ]);
        }

        if ($this->community->isMember()) {

            $membership = $this->community->getMembership();

            if (!$membership->send_notifications) {
                $this->addItem(array(
                    'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Receive Notifications for new content'),
                    'group' => 'admin',
                    'url' => $this->community->createUrl('/community/membership/receive-notifications'),
                    'icon' => '<i class="fa fa-bell"></i>',
                    'sortOrder' => 300,
                    'isActive' => (Yii::$app->controller->id == "module"),
                    'htmlOptions' => ['data-method' => 'POST']
                ));
            } else {
                $this->addItem(array(
                    'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Don\'t receive notifications for new content'),
                    'group' => 'admin',
                    'url' => $this->community->createUrl('/community/membership/revoke-notifications'),
                    'icon' => '<i class="fa fa-bell-o"></i>',
                    'sortOrder' => 300,
                    'isActive' => (Yii::$app->controller->id == "module"),
                    'htmlOptions' => ['data-method' => 'POST']
                ));
            }

            if (!$this->community->isCommunityOwner() && $this->community->canLeave()) {
                $this->addItem([
                    'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Cancel Membership'),
                    'group' => 'admin',
                    'url' => $this->community->createUrl('/community/membership/revoke-membership'),
                    'icon' => '<i class="fa fa-times"></i>',
                    'sortOrder' => 300,
                    'isActive' => (Yii::$app->controller->id == "module"),
                    'htmlOptions' => ['data-method' => 'POST']
                ]);
            }

            if ($membership->show_at_dashboard) {

                $this->addItem([
                    'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Hide posts on dashboard'),
                    'group' => 'admin',
                    'url' => $this->community->createUrl('/community/membership/switch-dashboard-display', ['show' => 0]),
                    'icon' => '<i class="fa fa-eye-slash"></i>',
                    'sortOrder' => 400,
                    'isActive' => (Yii::$app->controller->id == "module"),
                    'htmlOptions' => [
                        'data-method' => 'POST',
                        'class' => 'tt',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'left',
                        'title' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'This option will hide new content from this community at your dashboard')
                    ]
                ]);
            } else {

                $this->addItem([
                    'label' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'Show posts on dashboard'),
                    'group' => 'admin',
                    'url' => $this->community->createUrl('/community/membership/switch-dashboard-display', ['show' => 1]),
                    'icon' => '<i class="fa fa-eye"></i>',
                    'sortOrder' => 400,
                    'isActive' => (Yii::$app->controller->id == "module"),
                    'htmlOptions' => ['data-method' => 'POST',
                        'class' => 'tt',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'left',
                        'title' => Yii::t('CommunityModule.widgets_CommunityAdminMenuWidget', 'This option will show new content from this community at your dashboard')
                    ]
                ]);
            }
        }

        return parent::init();
    }
}

?>
