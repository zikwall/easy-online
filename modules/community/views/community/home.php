
<?php /*echo \zikwall\easyonline\modules\post\widgets\Form::widget(['contentContainer' => $community]); */?>
<?php

$emptyMessage = '';
if ($canCreatePosts) {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>This community is still empty!</b><br>Start by posting something here...');
} elseif ($isMember) {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>This community is still empty!</b>');
} else {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>You are not member of this community and there is no public content, yet!</b>');
}

/*echo zikwall\easyonline\modules\stream\widgets\StreamViewer::widget([
    'contentContainer' => $community,
    'streamAction' => '/community/community/stream',
    'messageStreamEmpty' => $emptyMessage,
    'messageStreamEmptyCss' => ($canCreatePosts) ? 'placeholder-empty-stream' : '',
]);*/
?>
