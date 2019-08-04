<?= \zikwall\easyonline\modules\community\widgets\InviteModal::widget([
    'model' => $model,
    'submitText' => Yii::t('CommunityModule.views_community_invite', 'Done'),
    'submitAction' => \yii\helpers\Url::to(['/community/create/invite', 'communityId' => $community->id])
]); ?>
