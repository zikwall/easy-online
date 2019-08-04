<?php
$user = $this->context->getUser();
?>

<div class="row" id="profile-main-container" >
    <div class="col-md-3" id="profile-left-sidebar-container">
        <div id="profile-left-sidebar">
            <?= \zikwall\easyonline\modules\ui\widgets\Photo::widget(); ?>
            <?= \zikwall\easyonline\modules\user\widgets\ProfileMenu::widget(['user' => $user]); ?>

            <div id="profile-left-sidebar-widgets">
                <?= \zikwall\easyonline\modules\user\widgets\ProfileSidebar::widget([
                    'user' => $user,
                    'widgets' => [
                        [\zikwall\easyonline\modules\user\widgets\Gifts::className()],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-9 col-no-right-padding" id="profile-main-content-container">
        <?= \zikwall\easyonline\modules\user\widgets\ProfileHeader::widget(['user' => $user]); ?>

        <?php if (isset($this->context->hideSidebar) && $this->context->hideSidebar) : ?>
            <div class="layout-content-container">
                <?= $content; ?>
            </div>
        <?php else: ?>
            <div class="row row-no-right-margin">
                <div class="col-md-8" style="padding-left: 15px;">
                    <div class="profile-content">
                        <?= $content; ?>
                    </div>
                </div>

                <div id="profile-right-sidebar-container" class="col-md-4 col-no-right-padding">
                    <div id="profile-right-sidebar" class="right-sidebar">

                        <?= \zikwall\easyonline\modules\user\widgets\ProfileRightSidebar::widget(['user' => $user]); ?>

                        <a class="page_block group_online_block group_subscribe_channel_block clear_fix" href="/app6451634_-29534144">
                            <div class="group_online_answer_pict float_left"></div>
                            <div class="group_online_answer_status float_left">
                                <p class="group_online_answer_status_title">Подписаться на канал</p>
                                <p class="group_online_answer_status_description">15026 подписчиков</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <script>
                window.userRightSidebarDefined = true;
            </script>

        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let userLeftSidebar = new StickySidebar('#profile-left-sidebar', {
            containerSelector: '#profile-main-content-container',
            innerWrapperSelector: '.fix',
            topSpacing: 55,
            bottomSpacing: 50
        });

        if (typeof window.userRightSidebarDefined != 'undefined' && window.userRightSidebarDefined) {
            let userRightSidebar = new StickySidebar('#profile-right-sidebar', {
                containerSelector: '#profile-right-sidebar-container',
                innerWrapperSelector: '.fix',
                topSpacing: 55,
                bottomSpacing: 50
            });
        }
    });
</script>
