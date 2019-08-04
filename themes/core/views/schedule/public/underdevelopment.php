<?php

use yii\bootstrap\Html;
use zikwall\easyonline\modules\schedule\models\ScheduleHelper;

/**
 * @var $couples []\zikwall\easyonline\modules\schedule\models\ScheduleAviableCouple
 */
?>
<style>
    .bt_guest_invitation {
        border-radius: 3px;
        background: url(//vk.com/images/landings/testing/bugs.png) no-repeat;
        background-color: rgba(0, 0, 0, 0);
        background-position-x: 0%;
        background-position-y: 0%;
        background-size: auto auto;
        color: #fff;
        background-color: #70aee0;
        background-position: right 0;
        background-size: auto 100%;
        box-sizing: border-box;
        padding: 23px 31px;
    }
    .bt_guest_invitation .title {
        font-weight: 500;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
        font-size: 17px;
    }
    .bt_guest_invitation .subtitle {
        line-height: 19px;
        width: 450px;
        margin-top: 8px;
    }

    .bt_page_content.no_top_padding {
        padding-top: 0;
    }
    .bt_page_content {
        padding: 15px 20px;
        padding-top: 15px;
    }

    .ui_search {
        z-index: 3;
        border-bottom: 1px solid #e7e8ec;
        background-color: #fff;
        position: relative;
    }
    .ui_search_input_block {
        position: relative;
    }
    .ui_search.ui_search_old .ui_search_sugg_list {
        width: auto;
        left: -1px;
        right: -1px;
        border-color: #e7e8ec;
        box-shadow: 0px 1px 3px 0px rgba(0,0,0,.04);
    }
    .ui_search_sugg_list {
        padding: 5px 0;
        border: 1px solid #c5d0db;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color: rgb(197, 208, 219);
        border-right-color: rgb(197, 208, 219);
        border-bottom-color: rgb(197, 208, 219);
        border-left-color: rgb(197, 208, 219);
        border-top: 1px solid #dde3e8;
        border-top-color: rgb(221, 227, 232);
        margin-top: -1px;
        position: absolute;
        width: 100%;
        box-sizing: border-box;
        background-color: #fff;
        z-index: 101;
        box-shadow: 0px 1px 3px 0px rgba(0,0,0,.12);
        border-radius: 0 0 3px 3px;
        display: none;
        -ms-user-select: none;
        user-select: none;
        -o-user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
    }
    .ui_search_filters_pane {
        padding: 7px 0;
        padding-top: 7px;
        padding-bottom: 7px;
        padding-top: 0;
        padding-bottom: 0;
        position: relative;
        border-top: 1px solid #e7e8ec;
        display: none;
        opacity: 0;
        filter: alpha(opacity=0);
        max-height: 0px;
        overflow: hidden;
        -o-transition: all 100ms linear;
        transition: all 100ms linear;
    }
    .ui_search_filters_reset {
        position: absolute;
        width: 38px;
        background: url(//vk.com/images/cross.png) no-repeat 50%;
        top: 0;
        bottom: 0;
        right: 6px;
        cursor: pointer;
        opacity: 0.75;
        filter: alpha(opacity=75);
    }
    .ui_search_filters_reset, .ui_search_reset {
        -o-transition: opacity 0.15s ease, visibility 0.15s ease;
        transition: opacity 0.15s ease, visibility 0.15s ease;
    }
    ui_search_custom input.ui_search_field {
        padding-right: 140px;
    }
    .bt_member_search .ui_search_field, .bt_reporter_search .ui_search_field {
        border-left: 5px solid transparent;
    }
    input.ui_search_field {
        background: url(//vk.com/images/search_icon.png) no-repeat;
        background-position-x: 0%;
        background-position-y: 0%;
        -ms-high-contrast-adjust: auto;
        padding-left: 28px;
        border-left: 20px solid transparent;
        background-position: 0;
        color: #000;
    }
    input.ui_search_field, input.ui_search_field ~ .placeholder .ph_input {
        padding: 14px 44px 13px 48px;
        padding-right: 44px;
        padding-left: 48px;
        box-sizing: border-box;
        width: 100%;
        border: none;
        border-left-width: medium;
        border-left-style: none;
        border-left-color: currentcolor;
        margin: 0;
        line-height: 18px;
    }

    .schedule-row {
        border-top: 1px solid #e7e8ec;
        display: table;
        width: 100%;
        table-layout: fixed;
        border-spacing: 10px;
    }
    .schedule-grid .schedule-row:first-child { border-top: none; }

    .schedule-column {
        display: table-cell;
        width: 85%;
    }
    .schedule-column-pair {
        width: 15%;
        border-right: 1px solid #e7e8ec;
    }
</style>

<div class="page_block">
    <div class="bt_guest_invitation">
        <div class="title">enCore Schedule</div>
        <div class="subtitle">Вы сможете опробовать и протестировать больше продуктов, если присоединитесь к VK Testers. Активных участников программы мы награждаем, лучших — приглашаем на стажировку.</div>
    </div>
</div>

<div class="page_block">
    <h2 class="ui_block_h2">
        <?= \zikwall\easyonline\modules\schedule\widgets\UnderdevelopmentDays::widget([
                'isContentContainer' => $isContentContainer
        ]); ?>
    </h2>
    <div class="ui_actions_menu_wrap _ui_menu_wrap groups_actions_menu _actions_menu">
        <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
            <span class="blind_label">Действия</span><div class="groups_actions_icons"></div>
        </div>

        <div class="ui_actions_menu _ui_menu">
            <div class="ui_rmenu_sep"></div>
        </div>
    </div>
    <div class="bt_page_content no_top_padding" id="bt_page_content">
        <div class="ui_search ui_search_field_empty bt_reporter_search ui_search_custom _wrap ui_search_old">
            <div class="ui_search_input_block">
                <div class="ui_search_reset">
                    <span class="blind_label">Отмена</span>
                </div>

                <input class="ui_search_field _field" id="bt_member_search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Занятие" type="text">
            </div>
            <div class="ui_search_sugg_list _ui_search_sugg_list"></div>
            <div class="ui_search_filters_pane" style="display: none;">
                <div class="ui_search_filters"></div>
                <div class="ui_search_filters_reset"></div>
            </div>
        </div>
        <br>

        <div class="schedule-grid">
            <?php foreach ($couples as $couple): ?>
            <div class="schedule-row">
                <div class="schedule-column schedule-column-pair">
                    <h5><small> <?= $couple->displayName; ?> </small></h5><br><b> <?= $couple->getDisplayTime(); ?> </b>
                </div>
                <div class="schedule-column">
                    <?php foreach (ScheduleHelper::getDailyDisciplines($day->id, $couple->id, $group->id) as $dailyDiscipline): ?>
                        <?= $this->render('@easyonline/modules/schedule/views/public/_discipline', [
                            'dailyDiscipline' => $dailyDiscipline
                        ]); ?>
                        <div class="separator"></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <br>
        <button class="flat_button secondary button_wide" id="load_more_reporters_btn" style="width: 100%;">Показать ещё</button>
    </div>

    <?= \zikwall\easyonline\modules\schedule\widgets\byWidget::widget(); ?>
</div>
