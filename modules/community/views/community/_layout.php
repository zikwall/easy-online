<?php
/**
 * @var \zikwall\easyonline\modules\community\models\Community $community
 * @var string $content
 */

$community = $this->context->contentContainer;
?>
<div class="container community-layout-container">
    <div class="row">
        <div class="col-md-12">
            <?= zikwall\easyonline\modules\community\widgets\Header::widget(['community' => $community]); ?>
        </div>
    </div>
    <div class="row community-content">
        <div class="col-md-2 layout-nav-container">
            <?= \zikwall\easyonline\modules\community\widgets\Menu::widget(['community' => $community]); ?>
            <br>
        </div>

        <?php if (isset($this->context->hideSidebar) && $this->context->hideSidebar) : ?>
            <div class="col-md-10 layout-content-container">
                <?= \zikwall\easyonline\modules\community\widgets\CommunityContent::widget([
                    'contentContainer' => $community,
                    'content' => $content
                ]) ?>
            </div>
        <?php else: ?>
            <div class="col-md-7 layout-content-container">
                <?= \zikwall\easyonline\modules\community\widgets\CommunityContent::widget([
                    'contentContainer' => $community,
                    'content' => $content
                ]) ?>
            </div>
            <div class="col-md-3 layout-sidebar-container">
                <?php
                echo \zikwall\easyonline\modules\community\widgets\Sidebar::widget(['community' => $community, 'widgets' => [
                        //[\zikwall\easyonline\modules\activity\widgets\Stream::class, ['streamAction' => '/community/community/stream', 'contentContainer' => $community], ['sortOrder' => 10]],
                        [\zikwall\easyonline\modules\community\modules\manage\widgets\PendingApprovals::class, ['community' => $community], ['sortOrder' => 20]],
                        [\zikwall\easyonline\modules\community\widgets\Members::class, ['community' => $community], ['sortOrder' => 30]]
                ]]);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
