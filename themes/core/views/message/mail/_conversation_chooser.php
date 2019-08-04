<?php

use zikwall\easyonline\modules\message\permissions\StartConversation;
use zikwall\easyonline\modules\message\widgets\NewMessageButton;
use yii\widgets\LinkPager;

/* @var $userMessages \zikwall\easyonline\modules\message\models\UserMessage[] */
/* @var $pagination \yii\data\Pagination */
/* @var $activeMessageId int */

$canStartConversation = Yii::$app->user->can(StartConversation::class);

?>


<div class="page_block ui_rmenu _im_right_menu ui_rmenu_pr ui_rmenu_sliding" role="list">
    <a id="ui_rmenu_all" href="/" class="ui_rmenu_item _ui_item_all">
        <div class="msg_mark_read_icon  off_mark_read"></div>
        <span>Все сообщения</span>
    </a>

    <a href="/" class="ui_rmenu_item _ui_item_unread">
        <span><span data-tab="unread" class="ui_rmenu_count ui_rmenu_count_grey im-right-menu--counter _im_right_menu_counter"></span> Непрочитанные</span>
    </a>

    <a href="/" class="ui_rmenu_item _ui_item_fav"> <span>Важные</span></a>
    <a href="/" class="ui_rmenu_item _ui_item_mr unshown">
        <span>
            <span class="ui_rmenu_count ui_rmenu_count_grey im-right-menu--counter _im_right_menu_counter"></span>
            Приглашения
        </span>
    </a>

    <div class="_im_ui_peers_list">
        <?php if (!empty($userMessages)) : ?>
            <div class="ui_rmenu_sep"></div>
            <?php foreach ($userMessages as $userMessage) : ?>
                <a href="/" class="_im_peer_tab ui_rmenu_item ui_rmenu_item_sel" title="Андрей Капитонов">
                    <span>
                        <span class="ui_rmenu_count im-right-menu--count _im_r_ct"></span>
                        <button type="button" class="im-right-menu--close _im_r_cl"></button>
                        <span class="im-right-menu--text _im_r_tx"><?= $userMessage->user->displayName; ?></span>
                    </span>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    <div class="ui_rmenu_slider _ui_rmenu_slider"></div>
</div>

