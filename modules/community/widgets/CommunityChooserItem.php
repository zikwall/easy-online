<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use zikwall\easyonline\modules\core\components\base\Widget;

class CommunityChooserItem extends Widget
{

    /**
     * @var string
     */
    public $community;

    /**
     * @var integer
     */
    public $updateCount = 0;

    /**
     * @var boolean
     */
    public $visible = true;

    /**
     * If true the item will be marked as a following community
     * @var boolean
     */
    public $isFollowing = false;

    /**
     * If true the item will be marked as a member community
     * @var string
     */
    public $isMember = false;

    public function run()
    {

        $data = $this->getDataAttribute();
        $badge = $this->getBadge();

        return $this->render('communityChooserItem', [
            'community' => $this->community,
            'updateCount' => $this->updateCount,
            'visible' => $this->visible,
            'badge' => $badge,
            'data' => $data
        ]);
    }

    public function getBadge()
    {
        if ($this->isMember) {
            return '<i class="fa fa-users badge-community pull-right type tt" title="' . Yii::t('CommunityModule.widgets_communityChooserItem', 'You are a member of this community') . '" aria-hidden="true"></i>';
        } else if ($this->isFollowing) {
            return '<i class="fa fa-star badge-community pull-right type tt" title="' . Yii::t('CommunityModule.widgets_communityChooserItem', 'You are following this community') . '" aria-hidden="true"></i>';
        } else if ($this->community->isArchived()) {
            return '<i class="fa fa-history badge-community pull-right type tt" title="' . Yii::t('CommunityModule.widgets_communityChooserItem', 'This community is archived') . '" aria-hidden="true"></i>';
        }
    }
    
    public function getDataAttribute()
    {
        if ($this->isMember) {
            return 'data-community-member';
        } else if ($this->isFollowing) {
            return 'data-community-following';
        } else if ($this->community->isArchived()) {
            return 'data-community-archived';
        } else {
            return 'data-community-none';
        }
    }
}
