<style>
    .im-page_classic.im-page .im-page--dcontent {
        overflow: visible;
        min-height: 100%;
        background: #fff;
        height: auto;
        margin-bottom: 15px;
        border-radius: 4px;
        padding-bottom: 45px;
    }
    .im-page .im-page--dcontent {
        height: 100%;
        box-sizing: border-box;
        overflow-y: hidden;
    }
    .ui_clean_list {
        margin: 0;
        display: block;
        padding: 0;
        list-style: none;
    }

    .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_classic.nim-dialog_unread,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_hovered,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog:hover,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.im-search-results-head,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.nim-dialog,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.im-search-results-head,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.nim-dialog,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.im-search-results-head,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.nim-dialog,
    .nim-dialog:not(.nim-dialog_deleted):hover+.im-search-results-head,
    .nim-dialog:not(.nim-dialog_deleted):hover+.nim-dialog {
        border-top: solid 1px #e7e8ec;
    }
    .nim-dialog:not(.nim-dialog_deleted)
    .nim-dialog_hovered,
    .nim-dialog:not(.nim-dialog_deleted)
    .nim-dialog_unread.nim-dialog_classic,
    .nim-dialog:not(.nim-dialog_deleted):hover {
        background: #f5f7fa;
    }
    .nim-dialog.nim-dialog_classic {
        height: 71px;
        padding-left: 20px;
    }
    .nim-dialog {
        height: 63px;
        box-sizing: border-box;
        padding: 0 0 0 15px;
        display: block;
        width: 100%;
        cursor: pointer;
    }
    .nim-dialog:not(.nim-dialog_deleted)
    .nim-dialog.nim-dialog_classic.nim-dialog_unread:before,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_hovered:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog:hover:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.im-search-results-head:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.nim-dialog:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.im-search-results-head:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.nim-dialog:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.im-search-results-head:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.nim-dialog:before, .nim-dialog:not(.nim-dialog_deleted):hover+.im-search-results-head:before, .nim-dialog:not(.nim-dialog_deleted):hover+.nim-dialog:before, .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_classic.nim-dialog_unread .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_classic.nim-dialog_unread .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_hovered .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog.nim-dialog_hovered .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog:hover .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog:hover .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.im-search-results-head .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.im-search-results-head .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.nim-dialog .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_hovered+.nim-dialog .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.im-search-results-head .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.im-search-results-head .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.nim-dialog .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_selected+.nim-dialog .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.im-search-results-head .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.im-search-results-head .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.nim-dialog .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic+.nim-dialog .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted):hover+.im-search-results-head .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted):hover+.im-search-results-head .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted):hover+.nim-dialog .nim-dialog--content, .nim-dialog:not(.nim-dialog_deleted):hover+.nim-dialog .nim-dialog--photo {
        margin-top: -1px;
    }
    .nim-dialog:not(.nim-dialog_deleted)
    .nim-dialog_hovered .nim-dialog--photo,
    .nim-dialog:not(.nim-dialog_deleted).nim-dialog_unread.nim-dialog_classic .nim-dialog--photo, .nim-dialog:not(.nim-dialog_deleted):hover .nim-dialog--photo {
        border-color: #f5f7fa;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--photo {
        padding-right: 14px;
        padding-top: 11px;
    }
    .nim-dialog .nim-dialog--photo {
        border-color: #fff;
        padding: 9px 7px 8px 0;
        float: left;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer, .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer img {
        width: 50px;
        height: 50px;
    }
    .nim-peer {
        width: 46px;
        height: 46px;
        position: relative;
        border-color: inherit;
        background-color: inherit;
    }
    .nim-peer .nim-peer--photo-w {
        overflow: hidden;
        border-radius: 50%;
    }
    .nim-peer .nim-peer--photo {
        background-color: inherit;
        overflow: hidden;
        margin-left: -2px;
        margin-bottom: -1px;
    }
    .nim-peer .im_grid {
        display: block;
        float: left;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer .nim-peer--photo .im_grid>img, .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer .nim-peer--photo>img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        -moz-force-broken-image-icon: 0;
        background-color: #fafbfc;
        position: relative;
        background-color: inherit;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer, .nim-dialog.nim-dialog_classic .nim-dialog--photo .nim-peer img {
        width: 50px;
        height: 50px;
    }
    .nim-peer .nim-peer--photo .im_grid>img, .nim-peer .nim-peer--photo>img {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        -moz-force-broken-image-icon: 0;
        background-color: #fafbfc;
        position: relative;
        background-color: inherit;
    }
    .nim-peer .im_grid img, .nim-peer .nim-peer--photo>img {
        margin-left: 2px;
        margin-bottom: 1px;
    }
    .nim-peer img {
        width: 46px;
        height: 46px;
        display: block;
    }


    .nim-dialog.nim-dialog_classic .nim-dialog--cw {
        height: 71px;
        box-sizing: border-box;
        padding: 10px 0;
    }
    .nim-dialog .nim-dialog--cw {
        padding: 8px 0;
        position: relative;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--date {
        right: 15px;
        top: 14px;
    }
    .nim-dialog .nim-dialog--date {
        color: #777e8c;
        font-size: 12.5px;
    }
    .nim-dialog .nim-dialog--date {
        position: absolute;
        top: 14px;
        right: 0;
        opacity: 0.7;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--close {
        right: -5px;
        margin-top: 5px;
    }
    .nim-dialog .nim-dialog--close {
        border: none;
        background: none;
        color: #2a5885;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;
        font-size: 13px;
        outline: 0;
        padding: 0;
        line-height: 1;
        background: url(data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.or…round%22%20stroke-linejoin%3D%22round%22%2F%3E%0A%3C%2Fg%3E%0A%3C%2Fsvg%3E);
        position: absolute;
        display: none;
        right: 0;
        opacity: 0.7;
        width: 12px;
        height: 12px;
        z-index: 1;
        margin-top: 6px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--markre {
        margin-top: 23px;
    }
    .nim-dialog .nim-dialog--markre {
        border: none;
        background: none;
        color: #2a5885;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;
        font-size: 13px;
        outline: 0;
        padding: 0;
        line-height: 1;
        display: none;
        background: url(//vk.com/images/icons/im_actions.png?7) 0 -389px;
        position: absolute;
        right: -10px;
        opacity: 0.7;
        width: 21px;
        height: 16px;
        z-index: 1;
        margin-top: 26px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--name {
        margin-top: 3px;
        margin-bottom: 7px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--name, .nim-dialog.nim-dialog_classic .nim-dialog--preview, .nim-dialog.nim-dialog_classic .nim-dialog--text-preview {
        font-size: 13px;
    }
    .nim-dialog .nim-dialog--name {
        font-size: 12.5px;
        font-weight: 500;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
        margin-bottom: 4px;
        margin-top: 6px;
        width: 100%;
        position: relative;
    }
    .nim-dialog.nim-dialog_verified .nim-dialog--name-w {
        padding-right: 0;
        position: relative;
        max-width: 59%;
    }
    .nim-dialog .nim-dialog--name .nim-dialog--name-w {
        color: #222;
        max-width: 70%;
        white-space: nowrap;
        display: inline-block;
        text-overflow: ellipsis;
        overflow: hidden;
        padding-bottom: 1px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--verfifed {
        margin-top: 0px;
    }
    .nim-dialog.nim-dialog_verified .nim-dialog--verfifed {
        position: absolute;
        display: inline-block;
        margin-top: -1px;
        width: 18px;
        height: 18px;
        margin-left: 7px;
        background: url(//vk.com/images/icons/verify.png) no-repeat 0 0;
    }
    .nim-dialog.nim-dialog_verified .nim-dialog--star {
        margin-left: 28px;
        margin-top: 2px;
    }
    .nim-dialog .nim-dialog--star {
        width: 12px;
        height: 12px;
        background: url(//vk.com/images/icons/im_actions.png?7) -4px -4px;
        margin-left: 6px;
        margin-top: 1px;
        cursor: pointer;
        vertical-align: middle;
        border: none;
        outline: 0;
        position: absolute;
        display: none;
    }

    .nim-dialog.nim-dialog_classic .nim-dialog--text-preview {
        max-width: 85%;
        width: 85%;
        line-height: 16px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--name, .nim-dialog.nim-dialog_classic .nim-dialog--preview, .nim-dialog.nim-dialog_classic .nim-dialog--text-preview {
        font-size: 13px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--text-preview {
        margin-top: -2px;
    }
    .nim-dialog.nim-dialog_failed .nim-dialog--text-preview, .nim-dialog.nim-dialog_unread .nim-dialog--text-preview, .nim-dialog.nim-dialog_unread.nim-dialog_prep-injected .nim-dialog--text-preview {
        width: 70%;
        min-height: 17px;
    }
    .nim-dialog .nim-dialog--preview, .nim-dialog .nim-dialog--text-preview {
        white-space: nowrap;
        max-width: 100%;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 12.5px;
        color: #656565;
        padding-bottom: 1px;
        line-height: 16px;
    }
    .nim-dialog .nim-dialog--typer-el {
        display: none;
        overflow: hidden;
        vertical-align: top;
        line-height: 16px;
        height: 16px;
    }
    .nim-dialog.nim-dialog_classic .nim-dialog--unread {
        right: 15px;
        bottom: 17px;
    }
    .nim-dialog.nim-dialog_failed .nim-dialog--unread, .nim-dialog.nim-dialog_unread .nim-dialog--unread, .nim-dialog.nim-dialog_unread.nim-dialog_prep-injected .nim-dialog--unread {
        display: block;
        opacity: 1;
        padding: 0 6px;
        margin-top: -17px;
        border-radius: 18px;
        background: #5181b8;
    }
    .nim-dialog .nim-dialog--unread {
        display: none;
        position: absolute;
        right: 0;
        color: #fff;
        font-size: 11px;
        font-weight: 500;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
        text-align: center;
        height: 18px;
        line-height: 19px;
        min-width: 6px;
    }



    .im-page .im-page--dialogs-footer.ui_grey_block {
        background: #fff;
    }
    .im-page_classic.im-page .im-page--dialogs-footer {
        bottom: 0;
        /*position: fixed;
        width: 550px;
        max-width: 550px;*/
        padding: 16px 20px;
        box-sizing: border-box;
        font-size: 12.5px;
        z-index: 102;
    }
    .im-page .im-page--dialogs-footer {
        height: 45px;
        position: absolute;
        bottom: 0;
        width: 100%;
        border-top: solid 1px #e4e6e9;
    }
    .im-page.im-page_classic .vk_msg_info_icon {
        margin-top: -3px;
        margin-right: 0;
    }
    .vk_block_mark_read_btn .vk_msg_info_icon, .vk_block_mark_read_btn ._im_dialogs_settings .msg_mark_read_icon {
        margin: 14px 14px 14px 5px;
    }

    .vk_msg_info_icon {
        width: 18px;
        height: 18px;
        display: block;
        float: right;
        margin: 14px;
    }
    .vk_msg_info_icon:before {
        content: '!';
        font-weight: bold;
        border: 2px solid #93a3bc;
        color: #93a3bc;
        width: 15px;
        height: 15px;
        line-height: 16px;
        display: block;
        text-align: center;
        border-radius: 50%;
    }
    .vk_block_mark_read_btn .im-page .im-page--dialogs-settings {
    }
    .im-page_classic.im-page .im-page--dialogs-settings {
        margin-top: -3px;
        margin-right: 0;
    }
    .im-page .im-page--dialogs-settings {
        background: url(//vk.com/images/icons/msg_cog.png);
        width: 18px;
        height: 18px;
        display: block;
        float: right;
        margin: 14px;
        -o-animation: none;
        animation: none;
    }

    .msg_mark_read_icon.off_mark_read {
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='%2392abc6'%3e%3cpath d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'/%3e%3c/svg%3e") !important;
    }
    .msg_mark_read_icon {
        float: right;
        margin: 4px 4px 0 0;
        width: 24px;
        height: 24px;
        cursor: pointer;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='%2392abc6'%3e%3cpath d='M21.99 8c0-.72-.37-1.35-.94-1.7L12 1 2.95 6.3C2.38 6.65 2 7.28 2 8v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2l-.01-10zM12 13L3.74 7.84 12 3l8.26 4.84L12 13z'/%3e%3c/svg%3e");
        opacity: 0.75;
        filter: alpha(opacity=75);
    }

    .im-right-menu--count {
        color: #42648b;
        font-weight: 500;
        vertical-align: top;
        background: none;
        border-radius: 0;
        margin: 6px;
        font-size: 13px;
    }
    .ui_rmenu_count.unshown, .ui_rmenu_count:empty {
        display: none;
    }
    .ui_rmenu_count {
        display: inline-block;
        float: right;
        font-weight: 400;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
        text-align: center;
        margin: 7px 10px 0 0;
        padding: 1px 6px;
        border-radius: 10px;
        background-color: #5181b8;
        font-size: 11px;
        height: 16px;
        line-height: 17px;
        min-width: 6px;
        color: #fff;
    }

     .im-right-menu--close {
        border: none;
        background: none;
        color: #2a5885;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Helvetica Neue,sans-serif;
        font-size: 13px;
        outline: 0;
        padding: 0;
        line-height: 1;
        width: 22px;
        height: 22px;
        cursor: pointer;
        display: none;
        opacity: 0.7;
        margin: 4px 6px 0 0;
        position: relative;
        float: right;
    }
    .im-right-menu--close:before {
        background: url(//vk.com/images/icons/im_actions.png?7) -4px -66px;
        width: 12px;
        height: 12px;
        content: '';
        display: block;
        position: absolute;
        right: 5px;
        top: 5px;
    }
    .im-right-menu--text {
        max-width: 175px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        vertical-align: top;
    }

    .online:after {
        bottom: 2%;
        right: 2%;
        border: 2px solid #fff;
        height: 16px;
        width: 16px;
    }
    .online:after {
        content: '';
        position: absolute;
        background-color: #8ac176;
        border-radius: 50%;
    }
    .nim-peer.online:after {
        border-color: inherit;
    }

    .no_posts {
        padding: 36px 20px;
        color: #656565;
        text-align: center;
        line-height: 19px;
    }
    .no_posts_cover {
        height: 97px;
        background: url(//vk.com/images/no_posts.png) no-repeat 50% 0;
    }
</style>

<?php
/* @var $messageId int */
/* @var $userMessages \zikwall\easyonline\modules\message\models\UserMessage[] */
/* @var $pagination \yii\data\Pagination */
?>

<div class="row">
    <div class="col-md-9">
        <div class="im-page js-im-page im-page_classic ">
            <div class="im-page--dialogs _im_page_dialogs page_block">

                <div class="ui_search ui_search_field_empty bt_reporter_search ui_search_custom _wrap ui_search_old">
                    <div class="ui_search_input_block">
                        <div class="ui_search_reset">
                            <span class="blind_label">Отмена</span>
                        </div>

                        <input class="ui_search_field _field" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Поиск" type="text">
                    </div>
                    <div class="ui_search_sugg_list _ui_search_sugg_list"></div>
                    <div class="ui_search_filters_pane">
                        <div class="ui_search_filters"></div>
                        <div class="ui_search_filters_reset"></div>
                    </div>
                </div>

                <ul class="im-page--dcontent ui_clean_list _im_page_dcontent">
                    <?php if (empty($userMessages)) : ?>
                        <div class="no_posts">
                            <div class="no_posts_cover"></div>
                            Диалогов пока нет.
                        </div>
                    <?php else: ?>
                        <?= $this->render('_messagePreview', ['userMessage' =>
                            $userMessage, 'active' => ($userMessage->message_id == $activeMessageId)]);
                        ?>
                    <?php endif; ?>
                </ul>

                <div class="im-page--dialogs-footer ui_grey_block _im_dialogs_settings">
                    <a href="#" class="vk_msg_info_icon"></a>
                    <div class="_im_settings_menu">
                        <a class="im-page--dialogs-settings _im_dialogs_cog_settings"></a>
                        <a class="_im_settings_action fl_r" data-action="spam">Спам</a>
                        <a class="_im_settings_action" data-action="sound">Отключить звуковые уведомления</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-3 col-no-right-padding">
        <?= $this->render('_conversation_chooser', [
            'userMessages' => $userMessages,
            'pagination' => $pagination,
            'activeMessageId' => $messageId
        ]) ?>
    </div>
</div>
