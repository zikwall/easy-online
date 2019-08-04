<?php



namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use yii\bootstrap\Html;
use zikwall\easyonline\modules\community\models\Community;

/**
 * UserFollowButton
 *
 * @author luke
 * @since 0.11
 */
class FollowButton extends \yii\base\Widget
{

    /**
     * @var \zikwall\easyonline\modules\user\models\User
     */
    public $community;

    /**
     * @var string label for follow button (optional)
     */
    public $followLabel = null;

    /**
     * @var string label for unfollow button (optional)
     */
    public $unfollowLabel = null;

    /**
     * @var string options for follow button 
     */
    public $followOptions = ['class' => 'btn btn-primary btn-sm'];

    /**
     * @var array options for unfollow button 
     */
    public $unfollowOptions = ['class' => 'btn btn-info btn-sm'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->followLabel === null) {
            $this->followLabel = Yii::t('CommunityModule.widgets_views_followButton', "Follow");
        }
        if ($this->unfollowLabel === null) {
            $this->unfollowLabel = Yii::t('CommunityModule.widgets_views_followButton', "Unfollow");
        }

        if (!isset($this->followOptions['class'])) {
            $this->followOptions['class'] = "";
        } 
        
        if (!isset($this->unfollowOptions['class'])) {
            $this->unfollowOptions['class'] = "";
        }

        if (!isset($this->followOptions['style'])) {
            $this->followOptions['style'] = "";
        }
        
        if (!isset($this->unfollowOptions['style'])) {
            $this->unfollowOptions['style'] = "";
        }
    }
 
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->user->isGuest || $this->community->isMember() || $this->community->visibility == Community::VISIBILITY_NONE) {
            return;
        }

        // Add class for javascript handling
        $this->followOptions['class'] .= ' followButton';
        $this->unfollowOptions['class'] .= ' unfollowButton';

        // Hide inactive button
        if ($this->community->isFollowedByUser()) {
            $this->followOptions['style'] .= ' display:none;';
        } else {
            $this->unfollowOptions['style'] .= ' display:none;';
        }

        // Add CommunityIds
        $this->followOptions['data-content-container-id'] = $this->community->id;
        $this->unfollowOptions['data-content-container-id'] = $this->community->id;
        
        // Add JS Action
        $this->followOptions['data-action-click'] = 'content.container.follow';
        $this->unfollowOptions['data-action-click'] = 'content.container.unfollow';
        
        // Add Action Url
        $this->followOptions['data-action-url'] = $this->community->createUrl('/community/community/follow');
        $this->unfollowOptions['data-action-url'] = $this->community->createUrl('/community/community/unfollow');
        
        // Add Action Url
        $this->followOptions['data-ui-loader'] = '';
        $this->unfollowOptions['data-ui-loader'] = '';

        $module = Yii::$app->getModule('community');

        // still enable unfollow if following was disabled afterwards.
        if ($module->disableFollow) {
            return Html::a($this->unfollowLabel, '#', $this->unfollowOptions);
        }

        return Html::a($this->unfollowLabel, '#', $this->unfollowOptions) .
                Html::a($this->followLabel, '#', $this->followOptions);
    }

}
