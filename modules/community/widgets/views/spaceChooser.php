<?php
/* @var $this \zikwall\easyonline\components\WebView */
/* @var $currentCommunity \zikwall\easyonline\modules\community\models\Community */

use yii\helpers\Url;
use yii\helpers\Html;
use zikwall\easyonline\modules\community\widgets\CommunityChooserItem;

\zikwall\easyonline\modules\community\assets\CommunityChooserAsset::register($this);

$noCommunityView = '<div class="no-community"><i class="fa fa-dot-circle-o"></i><br>' . Yii::t('CommunityModule.widgets_views_communityChooser', 'My communitys') . '<b class="caret"></b></div>';

$this->registerJsConfig('community.chooser', [
    'noCommunity' => $noCommunityView,
    'remoteSearchUrl' =>  Url::to(['/community/browse/search-json']),
    'text' => [
        'info.remoteAtLeastInput' => Yii::t('CommunityModule.widgets_views_communityChooser', 'To search for other communitys, type at least {count} characters.', ['count' => 2]),
        'info.emptyOwnResult' => Yii::t('CommunityModule.widgets_views_communityChooser', 'No member or following communitys found.'),
        'info.emptyResult' => Yii::t('CommunityModule.widgets_views_communityChooser', 'No result found for the given filter.'),
    ],
]);
?>

<li class="dropdown">
    <a href="#" id="community-menu" class="dropdown-toggle" data-toggle="dropdown">
        <!-- start: Show community image and name if chosen -->
        <?php if ($currentCommunity) : ?>
            <?=
            \zikwall\easyonline\modules\community\widgets\Image::widget([
                'community' => $currentCommunity,
                'width' => 32,
                'htmlOptions' => [
                    'class' => 'current-community-image',
            ]]);
            ?>
            <b class="caret"></b>
        <?php endif; ?>

        <?php if (!$currentCommunity) : ?>
            <?= $noCommunityView ?>
        <?php endif; ?>
        <!-- end: Show community image and name if chosen -->

    </a>
    <ul class="dropdown-menu" id="community-menu-dropdown">
        <li>
            <form action="" class="dropdown-controls">
                <div class="input-group">
                    <input type="text" id="community-menu-search" class="form-control" autocomplete="off" 
                           placeholder="<?= Yii::t('CommunityModule.widgets_views_communityChooser', 'Search'); ?>"
                           title="<?= Yii::t('CommunityModule.widgets_views_communityChooser', 'Search for communitys'); ?>">
                    <span id="community-directory-link" class="input-group-addon" >
                        <a href="<?= Url::to(['/directory/directory/communitys']); ?>">
                        <i class="fa fa-book"></i>
                        </a>
                    </span>
                    <div class="search-reset" id="community-search-reset"><i class="fa fa-times-circle"></i></div>
                </div>
            </form>
        </li>

        <li class="divider"></li>
        <li>
            <ul class="media-list notLoaded" id="community-menu-communitys">
                <?php foreach ($memberships as $membership): ?>
                    <?= CommunityChooserItem::widget(['community' => $membership->community, 'updateCount' => $membership->countNewItems(), 'isMember' => true]); ?>
                <?php endforeach; ?>
                <?php foreach ($followCommunitys as $followCommunity): ?>
                    <?= CommunityChooserItem::widget(['community' => $followCommunity, 'isFollowing' => true]); ?>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="remoteSearch">
            <ul id="community-menu-remote-search" class="media-list notLoaded"></ul>
        </li>

    <?php if ($canCreateCommunity): ?>
        <li>
            <div class="dropdown-footer">
                <a href="#" class="btn btn-info col-md-12" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/community/create/create']) ?>">
                    <?= Yii::t('CommunityModule.widgets_views_communityChooser', 'Create new community') ?>
                </a>
            </div>
        </li>
    <?php endif; ?>
    </ul>
</li>
