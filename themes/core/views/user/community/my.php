<?php
use zikwall\easyonline\modules\community\models\Community;
use yii\helpers\Html;
use zikwall\easyonline\modules\community\widgets\HeaderControlsMenu;

?>
<style>
    .flat_button.ui_load_more_btn {
        display: block;
        padding: 13px 0 14px;
        cursor: pointer;
        color: #2a5885;
        background-color: #fff;
        border-top: 1px solid #e7e8ec;
        border-radius: 0 0 4px 4px;
        -o-transition: background-color 40ms linear;
        transition: background-color 40ms linear;
    }
</style>
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
                <?php foreach($kindsOfCommunities[Community::STATUS_ENABLED] as $enabled): ?>
                    <div class="group_list_row clear_fix _gl_row ">
                        <a href="<?= $enabled->getUrl(); ?>" class="group_row_photo">
                            <img class="group_row_img" src="http://foto.cheb.ru/foto/foto.cheb.ru-23118.jpg">
                        </a>
                        <?= zikwall\easyonline\modules\community\widgets\HeaderControlsMenu::widget([
                            'community' => $enabled, 'template' => '@easyonline/themes/core/views/ui/widgets/dropDownMenuControlsList'
                        ]);
                        ?>
                        <div class="group_row_info">
                            <div class="group_row_labeled">
                                <a class="group_row_title" href="<?= $enabled->getUrl(); ?>"><?= Html::encode($enabled->name); ?></a>

                                <div class="group_row_labeled"><?= $enabled->type->title; ?></div>
                                <div class="group_row_labeled">2
                                    <span class="num_delim"> </span>206
                                    <span class="num_delim"> </span>334 участника
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php foreach($kindsOfCommunities[Community::STATUS_ARCHIVED] as $enabled): ?>
                    <div class="group_list_row clear_fix _gl_row ">
                        <a href="<?= $enabled->getUrl(); ?>" class="group_row_photo">
                            <img class="group_row_img" src="http://foto.cheb.ru/foto/foto.cheb.ru-23118.jpg">
                        </a>
                        <?= zikwall\easyonline\modules\community\widgets\HeaderControlsMenu::widget([
                                'community' => $enabled, 'template' => '@easyonline/themes/core/views/ui/widgets/dropDownMenuControlList'
                            ]);
                        ?>
                        <div class="group_row_info">
                            <div class="group_row_labeled">
                                <a class="group_row_title" href="<?= $enabled->getUrl(); ?>"><?= Html::encode($enabled->name); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php foreach($kindsOfCommunities[Community::STATUS_DISABLED] as $enabled): ?>
                    <div class="group_list_row clear_fix _gl_row ">
                        <a href="<?= $enabled->getUrl(); ?>" class="group_row_photo">
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
                                <a class="group_row_title" href="<?= $enabled->getUrl(); ?>"><?= Html::encode($enabled->name); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <div id="ui_groups_load_more" class="flat_button secondary ui_load_more_btn _ui_load_more_btn _ui_groups_load_more " data-type="groups">
                Показать больше сообществ
            </div>
        </div>
    </div>
</div>
