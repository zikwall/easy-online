<?= \zikwall\easyonline\modules\community\widgets\InviteModal::widget([
    'model' => $model,
    'submitText' => Yii::t('CommunityModule.views_community_invite', 'Send'),
    'submitAction' => $community->createUrl('/community/membership/invite'),
    'searchUrl' => $community->createUrl('/community/membership/search-invite')
]); ?>
