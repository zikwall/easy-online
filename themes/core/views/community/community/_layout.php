<?php
/**
 * @var \zikwall\easyonline\modules\community\models\Community $community
 * @var string $content
 */

$community = $this->context->contentContainer;

use zikwall\easyonline\modules\community\widgets\Header;
?>

<div class="row" id="community-main-row">
    <div class="col-md-12 col-no-right-padding">
        <?= Header::widget(['community' => $community]); ?>
    </div>

    <div class="col-md-9">
        <?= \zikwall\easyonline\modules\community\widgets\CommunityContent::widget([
            'contentContainer' => $community,
            'content' => $content
        ]) ?>
    </div>

    <div id="community-sidebar-container" class="col-md-3 layout-nav-container col-no-right-padding">
        <div id="community-sidebar">
            <?= \zikwall\easyonline\modules\community\widgets\Menu::widget(['community' => $community]); ?>

            <?= \zikwall\easyonline\modules\community\widgets\Sidebar::widget(['community' => $community, 'widgets' => [
                //[\zikwall\easyonline\modules\activity\widgets\Stream::class, ['streamAction' => '/community/community/stream', 'contentContainer' => $community], ['sortOrder' => 10]],
                [\zikwall\easyonline\modules\community\modules\manage\widgets\PendingApprovals::class, ['community' => $community], ['sortOrder' => 20]],
                [\zikwall\easyonline\modules\community\widgets\Members::class, ['community' => $community], ['sortOrder' => 30]]
            ]]);
            ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let communitySidebar = new StickySidebar('#community-sidebar', {
            containerSelector: '#community-sidebar-container',
            innerWrapperSelector: '.fix',
            topSpacing: 55,
            bottomSpacing: 50
        });
    });
</script>

