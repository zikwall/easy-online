<?php

use yii\helpers\Html;
?>
<?php if (count($friends) > 0) { ?>
    <div class="panel panel-default follower" id="profile-follower-panel">
        <?= \zikwall\easyonline\modules\core\widgets\PanelMenu::widget(['id' => 'profile-friends-panel']); ?>

        <div class="panel-heading"><strong><?= Yii::t('FriendshipModule.base', 'Friends'); ?></strong> (<?= $totalCount; ?>)</div>

        <div class="panel-body">
            <?php foreach ($friends as $friend): ?>
                <a href="<?= $friend->getUrl(); ?>">
                    <?= Html::encode($friend->displayName); ?>
                </a>
            <?php endforeach; ?>
            <?php if ($totalCount > $limit): ?>
                <br />
                <br />
                <?= Html::a(Yii::t('FriendshipModule.base', 'Show all friends'), ['/user/friendship/list/popup', 'userId' => $user->id], ['class' => 'btn btn-xs', 'data-target' => '#globalModal']); ?>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>
