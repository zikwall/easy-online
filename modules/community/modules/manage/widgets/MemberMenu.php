<?php

namespace zikwall\easyonline\modules\community\modules\manage\widgets;

use Yii;
use zikwall\easyonline\modules\community\modules\manage\models\MembershipSearch;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class MemberMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@core/widgets/views/tabMenu";

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItem(array(
            'label' => Yii::t('CommunityModule.widgets_CommunityMembersMenu', 'Members'),
            'url' => $this->community->createUrl('/community/manage/member/index'),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id === 'member'),
        ));

        if ($this->countPendingInvites() != 0) {
            $this->addItem(array(
                'label' => Yii::t('CommunityModule.widgets_CommunityMembersMenu', 'Pending Invites') . '&nbsp;&nbsp;<span class="label label-danger">'.$this->countPendingInvites().'</span>',
                'url' => $this->community->createUrl('/community/manage/member/pending-invitations'),
                'sortOrder' => 200,
                'isActive' => (Yii::$app->controller->action->id == 'pending-invitations'),
            ));
        }
        if ($this->countPendingApprovals() != 0) {
            $this->addItem(array(
                'label' => Yii::t('CommunityModule.widgets_CommunityMembersMenu', 'Pending Approvals'). '&nbsp;&nbsp;<span class="label label-danger">'.$this->countPendingApprovals().'</span>',
                'url' => $this->community->createUrl('/community/manage/member/pending-approvals'),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->action->id == 'pending-approvals'),
            ));
        }

        if ($this->community->isCommunityOwner()) {
            $this->addItem(array(
                'label' => Yii::t('CommunityModule.widgets_CommunityMembersMenu', 'Owner'),
                'url' => $this->community->createUrl('/community/manage/member/change-owner'),
                'sortOrder' => 500,
                'isActive' => (Yii::$app->controller->action->id == 'change-owner'),
            ));
        }


        parent::init();
    }

    /**
     * Returns the number of currently invited users
     *
     * @return int currently invited members
     */
    protected function countPendingInvites()
    {
        $searchModel = new MembershipSearch();
        $searchModel->community_id = $this->community->id;
        $searchModel->status = Membership::STATUS_INVITED;
        return $searchModel->search([])->getCount();
    }

    /**
     * Returns the number of currently pending approvals
     *
     * @return int currently pending approvals
     */
    protected function countPendingApprovals()
    {
        $searchModel = new MembershipSearch();
        $searchModel->community_id = $this->community->id;
        $searchModel->status = Membership::STATUS_APPLICANT;
        return $searchModel->search([])->getCount();
    }

}
