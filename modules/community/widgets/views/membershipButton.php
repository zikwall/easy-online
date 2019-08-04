<?php

use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;
use yii\helpers\Html;

if ($membership === null) {
    if ($community->canJoin()) {
        if ($community->join_policy == Community::JOIN_POLICY_APPLICATION) {
            echo Html::a(Yii::t('CommunityModule.widgets_views_membershipButton', 'Request membership'), $community->createUrl('/community/membership/request-membership-form'), array('id' => 'requestMembershipButton', 'class' => 'btn btn-primary', 'data-target' => '#globalModal'));
        } else {
            echo Html::a(Yii::t('CommunityModule.widgets_views_membershipButton', 'Become member'), $community->createUrl('/community/membership/request-membership'), array('id' => 'requestMembershipButton', 'class' => 'btn btn-primary', 'data-method' => 'POST'));
        }
    }
} elseif ($membership->status == Membership::STATUS_INVITED) {
    ?>
    <div class="btn-group">
        <?= Html::a(Yii::t('CommunityModule.widgets_views_membershipButton', 'Accept Invite'), $community->createUrl('/community/membership/invite-accept'), array('class' => 'btn btn-info', 'data-method' => 'POST')); ?>
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li><?= Html::a(Yii::t('CommunityModule.widgets_views_membershipButton', 'Deny Invite'), $community->createUrl('/community/membership/revoke-membership'), array('data-method' => 'POST')); ?></li>
        </ul>
    </div>
    <?php
} elseif ($membership->status == Membership::STATUS_APPLICANT) {
    echo Html::a(Yii::t('CommunityModule.widgets_views_membershipButton', 'Cancel pending membership application'), $community->createUrl('/community/membership/revoke-membership'), array('data-method' => 'POST', 'class' => 'btn btn-primary'));
}
