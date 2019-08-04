<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use zikwall\easyonline\components\Widget;
use zikwall\easyonline\modules\community\permissions\CreatePrivateCommunity;
use zikwall\easyonline\modules\community\permissions\CreatePublicCommunity;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\user\models\Follow;
use yii\helpers\Html;

/**
 * Class Chooser
 * @package zikwall\easyonline\modules\community\widgets
 */
class Chooser extends Widget
{

    public static function getCommunityResult($community, $withChooserItem = true, $options = [])
    {
        $communityInfo = [];
        $communityInfo['guid'] = $community->guid;
        $communityInfo['title'] = Html::encode($community->name);
        $communityInfo['tags'] = Html::encode($community->tags);
        $communityInfo['image'] = Image::widget(['community' => $community, 'width' => 24]);
        $communityInfo['link'] = $community->getUrl();

        if ($withChooserItem) {
            $options = array_merge(['community' => $community, 'isMember' => false, 'isFollowing' => false], $options);
            $communityInfo['output'] = \zikwall\easyonline\modules\community\widgets\CommunityChooserItem::widget($options);
        }

        return $communityInfo;
    }

    /**
     * Displays / Run the Widgets
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return;
        }

        return $this->render('communityChooser', [
                    'currentCommunity' => $this->getCurrentCommunity(),
                    'canCreateCommunity' => $this->canCreateCommunity(),
                    'memberships' => $this->getMemberships(),
                    'followCommunitys' => $this->getFollowCommunitys()
        ]);
    }

    protected function getFollowCommunitys()
    {
        if (!Yii::$app->user->isGuest) {
            return Follow::getFollowedCommunitysQuery(Yii::$app->user->getIdentity())->all();
        }
    }

    protected function getMemberships()
    {
        if (!Yii::$app->user->isGuest) {
            return Membership::findByUser(Yii::$app->user->getIdentity())->all();
        }
    }

    protected function canCreateCommunity()
    {
        return (Yii::$app->user->permissionmanager->can(new CreatePublicCommunity) || Yii::$app->user->permissionmanager->can(new CreatePrivateCommunity()));
    }

    protected function getCurrentCommunity()
    {
        if (Yii::$app->controller instanceof \zikwall\easyonline\modules\content\components\ContentContainerController) {
            if (Yii::$app->controller->contentContainer !== null && Yii::$app->controller->contentContainer instanceof \zikwall\easyonline\modules\community\models\Community) {
                return Yii::$app->controller->contentContainer;
            }
        }

        return null;
    }

    /**
     * Returns the membership query
     * 
     * @deprecated since version 1.2
     * @return type
     */
    protected function getMembershipQuery()
    {
        $query = Membership::find();

        if (Yii::$app->getModule('community')->settings->get('communityOrder') == 0) {
            $query->orderBy('name ASC');
        } else {
            $query->orderBy('last_visit DESC');
        }

        $query->joinWith('community');
        $query->where(['community_membership.user_id' => Yii::$app->user->id, 'community_membership.status' => Membership::STATUS_MEMBER]);

        return $query;
    }

}

?>
