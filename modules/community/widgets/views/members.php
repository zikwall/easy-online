<?php

use zikwall\easyonline\modules\core\libs\Html;
use zikwall\easyonline\modules\user\widgets\Image;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\core\widgets\PanelMenu;
?>

<div class="panel panel-default members" id="community-members-panel">
    <?= PanelMenu::widget(['id' => 'community-members-panel']); ?>
    <div class="panel-heading"><?= Yii::t('CommunityModule.widgets_views_communityMembers', '<strong>Community</strong> members'); ?> (<?= $totalMemberCount ?>)</div>
    <div class="panel-body">
        <?php foreach ($users as $user) : ?>
            <?php
            if (in_array($user->id, $privilegedUserIds[Community::USERGROUP_OWNER])) {
                // Show Owner image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    //'tooltipText' => Yii::t('CommunityModule.base', 'Owner:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid '  /*$this->theme->variable('success')*/]
                ]);
            } elseif (in_array($user->id, $privilegedUserIds[Community::USERGROUP_ADMIN])) {
                // Show Admin image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    //'tooltipText' => Yii::t('CommunityModule.base', 'Administrator:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid ' /*. $this->theme->variable('success')*/]
                ]);
            } elseif (in_array($user->id, $privilegedUserIds[Community::USERGROUP_MODERATOR])) {
                // Show Moderator image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    //'tooltipText' => Yii::t('CommunityModule.base', 'Moderator:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid ' /*. $this->theme->variable('info')*/]
                ]);
            } else {
                // Standard member
                echo Image::widget(['user' => $user, 'width' => 32, 'showTooltip' => true]);
            }
            ?>
        <?php endforeach; ?>

        <?php if ($showListButton) : ?>
            <br>
            <a href="<?= $urlMembersList; ?>" data-target="#globalModal" class="btn btn-default btn-sm"><?= Yii::t('CommunityModule.widgets_views_communityMembers', 'Show all'); ?></a>
        <?php endif; ?>

    </div>
</div>
