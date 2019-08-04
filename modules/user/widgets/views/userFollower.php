<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\user\models\User;

/**
 * @var $user User
 */

$followers = $user->getFollowers(User::find()->limit(16));

?>
<?php if (count($followers) > 0) { ?>
    <div class="panel panel-default follower" id="profile-follower-panel">

        <!-- Display panel menu widget -->
        <?= \zikwall\easyonline\modules\core\widgets\PanelMenu::widget(['id' => 'profile-follower-panel']); ?>

        <div class="panel-heading"><?= Yii::t('UserModule.widgets_views_userFollower', '<strong>User</strong> followers'); ?></div>

        <div class="panel-body">
            <?php foreach ($followers as $follower): ?>
                <a href="<?= $follower->getUrl(); ?>">
                    <?= Html::encode($follower->displayName);?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>

<?php
$following = $user->getFollowingObjects(User::find()->limit(16));
?>
<?php if (count($following) > 0) { ?>
    <div class="panel panel-default follower" id="profile-following-panel">

        <!-- Display panel menu widget -->
        <?= \zikwall\easyonline\modules\core\widgets\PanelMenu::widget(['id' => 'profile-following-panel']); ?>

        <div class="panel-heading">
            <?= Yii::t('UserModule.widgets_views_userFollower', '<strong>Following</strong> user'); ?>
        </div>

        <div class="panel-body">
            <?php foreach ($following as $followingUser): ?>
                <a href="<?= $followingUser->getUrl(); ?>">
                    <?= Html::encode($followingUser->displayName);?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

<?php } ?>
