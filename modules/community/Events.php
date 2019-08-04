<?php

namespace zikwall\easyonline\modules\community;

use zikwall\easyonline\modules\community\models\Type;
use zikwall\easyonline\modules\community\permissions\ManageCommunity;
use Yii;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;
use yii\web\HttpException;
use yii\helpers\Url;

class Events extends \yii\base\BaseObject
{
    public static function onSidebarMenuInit($event)
    {
        if (Yii::$app->user->getIsGuest()) {
            return true;
        }

        $user = Yii::$app->user->getIdentity();

        $event->sender->addItem([
            'label' => 'Сообщества',
            'sortOrder' => 300,
            //'isActive' => false,
            'url' => $user->createUrl('/communities'),
        ]);
    }

    public static function onAdminCommunityMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('CommunityModule.communityType', 'Types'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'community' && Yii::$app->controller->id = 'type'),
            'url' => Url::to(['/community/type/type-admin/index']),
        ]);
    }

    public static function onCommunityAdminDefaultMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('CommunityModule.communityType', 'Image'),
            'sortOrder' => 290,
            'isActive' => (Yii::$app->controller->id == 'space-admin' && Yii::$app->controller->action->id == 'image'),
            'url' => $event->sender->community->createUrl('/community/type/space-admin/image'),
        ]);

        if (Type::find()->count() > 1) {
            $event->sender->addItem([
                'label' => Yii::t('CommunityModule.communityType', 'Type'),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->id == 'space-admin' && Yii::$app->controller->action->id == 'index'),
                'url' => $event->sender->community->createUrl('/community/type/space-admin/index'),
            ]);
        }
    }

    public static function onCommunityBeforeInsert($event)
    {
        /**
         * @var $community Community
         */
        $community = $event->sender;

        if ($community->community_type_id == "") {
            $type = Type::find()->orderBy(['sort_key' => SORT_ASC])->one();
            $community->community_type_id = $type->id;
        }
    }

    public function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Communities'),
            'id' => 'communities',
            'url' => Url::toRoute('/community/admin'),
            //'icon' => '<i class="fa fa-inbox"></i>',
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'community'),
            'isVisible' => Yii::$app->user->can([
                ManageCommunity::class,
                ManageSettings::class,
            ]),
        ]);
    }

    public static function onSearchRebuild($event)
    {
        foreach (Community::find()->each() as $community) {
            Yii::$app->search->add($community);
        }
    }

    public static function onUserDelete($event)
    {
        $user = $event->sender;

        // Check if the user owns some communitys
        foreach (Membership::GetUserCommunitys($user->id) as $community) {
            if ($community->isCommunityOwner($user->id)) {
                throw new HttpException(500, Yii::t('CommunityModule.base', 'Could not delete user who is a community owner! Name of Community: {communityName}', array('communityName' => $community->name)));
            }
        }

        // Cancel all community memberships
        foreach (Membership::findAll(['user_id' => $user->id]) as $membership) {
            // Avoid activities
            $membership->delete();
        }

        // Cancel all community invites by the user
        foreach (Membership::findAll(['originator_user_id' => $user->id, 'status' => Membership::STATUS_INVITED]) as $membership) {
            // Avoid activities
            $membership->delete();
        }

        return true;
    }

    public static function onConsoleApplicationInit($event)
    {
        $application = $event->sender;
        $application->controllerMap['community'] = commands\CommunityController::class;
    }
}
