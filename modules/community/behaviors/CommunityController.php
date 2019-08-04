<?php

namespace zikwall\easyonline\modules\community\behaviors;

use Yii;
use yii\base\Behavior;
use zikwall\easyonline\modules\community\models\Community;
use yii\web\HttpException;
use zikwall\easyonline\modules\core\components\base\Controller;

class CommunityController extends Behavior
{
    public $community = null;

    public static $subLayout = '@community/views/community/_layout';

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function getCommunity()
    {
        if ($this->community != null) {
            return $this->community;
        }

        // Get Community GUID by parameter
        $guid = Yii::$app->request->get('sguid');

        // Try Load the community
        $this->community = Community::findOne([
            'guid' => $guid
        ]);
        if ($this->community == null)
            throw new HttpException(404, Yii::t('CommunityModule.behaviors_CommunityControllerBehavior', 'Community not found!'));

        $this->checkAccess();
        return $this->community;
    }

    public function checkAccess()
    {
        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') && Yii::$app->user->isGuest && $this->community->visibility != Community::VISIBILITY_ALL) {
            throw new HttpException(401, Yii::t('CommunityModule.behaviors_CommunityControllerBehavior', 'You need to login to view contents of this community!'));
        }

        // Save users last action on this community
        $membership = $this->community->getMembership(Yii::$app->user->id);
        if ($membership != null) {
            $membership->updateLastVisit();
        } else {

            // Super Admin can always enter
            if (! Yii::$app->user->isAdmin()) {
                // Community invisible?
                if ($this->community->visibility == Community::VISIBILITY_NONE) {
                    // Not Community Member
                    throw new HttpException(404, Yii::t('CommunityModule.behaviors_CommunityControllerBehavior', 'Community is invisible!'));
                }
            }
        }
    }

    public function beforeAction($action)
    {
        $this->owner->prependPageTitle($this->community->name);
    }
}

?>
