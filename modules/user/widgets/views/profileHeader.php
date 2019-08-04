<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="panel panel-default panel-profile">

    <div class="panel-profile-header">

    </div>

    <div class="panel-body">

        <div class="panel-profile-controls">
            <!-- start: User statistics -->
            <div class="row">
                <div class="col-md-12">
                    <div class="statistics pull-left">

                        <?php if ($friendshipsEnabled): ?>
                            <a href="<?= Url::to(['/friendship/list/popup', 'userId' => $user->id]); ?>" data-target="#globalModal">
                                <div class="pull-left entry">
                                    <span class="count"><?= $countFriends; ?></span>
                                    <br>
                                    <span class="title"><?= Yii::t('UserModule.widgets_views_profileHeader', 'Friends'); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                        <?php if ($followingEnabled): ?>
                            <a href="<?= $user->createUrl('/user/profile/follower-list'); ?>" data-target="#globalModal">
                                <div class="pull-left entry">
                                    <span class="count"><?= $countFollowers; ?></span>
                                    <br>
                                    <span class="title"><?= Yii::t('UserModule.widgets_views_profileHeader', 'Followers'); ?></span>
                                </div>
                            </a>
                            <a href="<?= $user->createUrl('/user/profile/followed-users-list'); ?>" data-target="#globalModal">
                                <div class="pull-left entry">
                                    <span class="count"><?= $countFollowing; ?></span>
                                    <br>
                                    <span class="title"><?= Yii::t('UserModule.widgets_views_profileHeader', 'Following'); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    <!-- end: User statistics -->

                    <div class="controls controls-header pull-right">
                        <?=
                        zikwall\easyonline\modules\user\widgets\ProfileHeaderControls::widget([
                            'user' => $user,
                            'widgets' => [
                                [\zikwall\easyonline\modules\user\widgets\ProfileEditButton::class, ['user' => $user], []],
                                [\zikwall\easyonline\modules\user\widgets\UserFollowButton::class, ['user' => $user], []],
                                [\zikwall\easyonline\modules\user\modules\friendship\widgets\FriendshipButton::class, ['user' => $user], []],
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

