<style>
    .schedule_compact_mobile_promo_picture {
        position: absolute;
        right: 32px;
        bottom: 0;
        width: 350px;
        height: 200px;
    }
    .schedule_compact_mobile_promo_title {
        margin: 0 0 16px;
        max-width: 150px;
        font-size: 20px;
        line-height: 24px;
        font-weight: 500;
        -webkit-font-smoothing: subpixel-antialiased;
        -moz-osx-font-smoothing: auto;
    }
    .schedule_compact_mobile_promo_text {
        max-width: 150px;
        color: #656565;
        font-size: 14px;
        line-height: 19px;
    }
</style>
<div class="page_block" style="padding-top: 50px;">
    <div class="page_info_wrap">
    <img src="//vk.com/images/login/compact_mobile_promo.png" srcset="//vk.com/images/login/compact_mobile_promo.png, //vk.com/images/login/compact_mobile_promo_2x.png 2x" class="schedule_compact_mobile_promo_picture" width="350" height="200">
    <h2 class="schedule_compact_mobile_promo_title">Университет для&nbsp;мобильных устройств</h2>
    <div class="schedule_compact_mobile_promo_text">Скачать для&nbsp;<a href="https://itunes.apple.com/ru/app/">iPhone</a> или&nbsp;
        <a href="https://play.google.com/store/apps/details">Android</a></div>
    </div>
</div>

<div class="page_block">
    <h2 class="ui_block_h2">
       <?= \zikwall\easyonline\modules\ui\widgets\ExampleTabs::widget(); ?>
    </h2>
    <div id="group_u_search_input_wrap" class="search_query_wrap">
        <div class="ui_search_new ui_search ui_search_field_empty groups_list_search _wrap">
            <div class="ui_search_input_block">
                <button class="ui_search_button_search _ui_search_button_search"></button>
                <div class="ui_search_input_inner">
                    <div class="ui_search_progress"></div>
                    <div class="ui_search_controls">
                        <button class="ui_search_reset_button ui_search_button_control"></button>
                    </div>
                    <div class="ui_search_suggester_shadow _ui_search_suggester_shadow"></div>
                    <input class="ui_search_field _field" id="groups_list_search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="Поиск по факультетам" type="text">
                </div>
            </div>
            <div class="ui_search_sugg_list _ui_search_sugg_list"></div>
        </div>
    </div>
    <div class="clear_fix">
        <div id="groups_list_tab_groups">
            <div id="groups_list_groups" class="groups_list">
                <?php for($i = 0; $i <= 20; $i++): ?>
                    <?php foreach ($faculties as $faculty): ?>
                    <div class="group_list_row clear_fix _gl_row ">
                        <a href="/schedule/public/global?faculty=<?= $faculty->id; ?>" class="group_row_photo">
                            <img class="group_row_img" src="http://foto.cheb.ru/foto/foto.cheb.ru-23118.jpg">
                        </a>
                        <div class="group_row_actions">
                            <div class="ui_actions_menu_wrap _ui_menu_wrap groups_actions_menu _actions_menu">
                                <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
                                    <span class="blind_label">Действия</span><div class="groups_actions_icons"></div>
                                </div>
                                <div class="ui_actions_menu _ui_menu">
                                    <a class="ui_actions_menu_item"  tabindex="0" role="link">Отписаться</a>
                                    <div class="ui_actions_menu_sep"></div>
                                    <a class="ui_actions_menu_item" data-value="0" tabindex="0" role="link">Уведомлять о записях</a>
                                    <a class="ui_actions_menu_item" data-value="0" tabindex="0" role="link">Сохранить в закладках</a>
                                    <a class="ui_actions_menu_item group_menu_action" data-value="0" tabindex="0" role="link">Добавить в левое меню</a>
                                </div>
                            </div>
                        </div>
                        <div class="group_row_info">
                            <div class="group_row_labeled">
                                <a class="group_row_title" href="/schedule/public/global?faculty=<?= $faculty->id; ?>"><?= $faculty->fullname; ?></a>
                            </div>
                            <div class="group_row_labeled"><?= $faculty->building->name; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
