<?php
$user = $this->context->getUser();
?>

<div class="container profile-layout-container">
    <div class="row">
        <div class="col-md-12">
            <?= \zikwall\easyonline\modules\user\widgets\ProfileHeader::widget(['user' => $user]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 layout-nav-container">
            <?= \zikwall\easyonline\modules\user\widgets\ProfileMenu::widget(['user' => $this->context->user]); ?>
            <?= \zikwall\easyonline\modules\user\widgets\UserTags::widget(['user' => $this->context->user,]); ?>
        </div>

        <?php if (isset($this->context->hideSidebar) && $this->context->hideSidebar) : ?>
            <div class="col-md-10 layout-content-container">
                <?= $content; ?>
            </div>
        <?php else: ?>
            <div class="col-md-7 layout-content-container">
                <?= $content; ?>
            </div>
            <div class="col-md-3 layout-sidebar-container">
                <?php
                echo \zikwall\easyonline\modules\user\widgets\ProfileSidebar::widget([
                    'user' => $this->context->user,
                    'widgets' => [
                        [\zikwall\easyonline\modules\user\widgets\UserTags::class, ['user' => $this->context->user], ['sortOrder' => 10]],
                        [\zikwall\easyonline\modules\user\modules\friendship\widgets\FriendsPanel::class, ['user' => $this->context->user], ['sortOrder' => 30]],
                        [\zikwall\easyonline\modules\user\widgets\UserFollower::class, ['user' => $this->context->user], ['sortOrder' => 40]],
                    ]
                ]);
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
