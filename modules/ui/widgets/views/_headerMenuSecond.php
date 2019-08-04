<?php
$img = Yii::getAlias('@web') . '/resources/img';
?>

<div id="topbar-second" class="topbar">
    <div class="container">
        <div class="global-nav" data-section-term="top_nav">
            <div class="global-nav-inner">
                <div class="container-menu">
                    <div role="navigation" style="display: inline-block;">
                        <ul class="nav js-global-actions" id="global-actions">
                            <li class="people notifications active">
                                <a class="js-nav js-tooltip js-dynamic-tooltip" data-placement="bottom" href="javascript::void();">
                                    <span class="Icon Icon--notificationsFilled Icon--large u-textUserColor"></span>
                                    <span class="text" aria-hidden="true">Уведомления</span>
                                    <span class="count">
                                        <span class="count-inner">0</span>
                                    </span>
                                </a>
                            </li>
                            <li class="dm-nav">
                                <a role="button" href="javascript::void();" class="js-tooltip js-dynamic-tooltip global-dm-nav" data-placement="bottom">
                                    <span class="Icon Icon--dm Icon--large"></span>
                                    <span class="text">Сообщения</span>
                                    <span class="dm-new"><span class="count-inner"></span></span>
                                </a>
                            </li>
                            <li id="global-nav-home" class="dm-nav">
                                <a class="js-nav js-tooltip js-dynamic-tooltip" data-placement="bottom" href="javascript::void();">
                                    <span class="Icon Icon--homeFilled Icon--large u-textUserColor"></span>
                                    <span class="text" aria-hidden="true">Главная</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="pull-right nav-extras">
                        <div role="search">
                            <div class="form-group form-group-search">
                                <div class="form-group field-search-input-field">
                                    <input type="text" id="search-input-field" class="form-control form-search search-change" value="" title="Поиск" placeholder="Поиск" onblur="showNav(true);" onfocus="showNav(false);">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <button type="submit" class="btn btn-search btn-default btn-sm form-button-search" data-ui-loader="">
                                    Поиск
                                </button>
                            </div>

                            <div id="ts_cont_wrap" class="ts_cont_wrap" style="">
                                <a href="#" class="ts_search_link clear_fix" id="ts_search_link">
                                    <span class="ts_contact_name float_left">Показать все результаты</span>
                                    <div class="ts_contact_status "></div>
                                </a>
                                <div class="ts_search_sep">Сообщества</div>

                                <?php for($i = 1; $i <= rand(2, 4); $i++): ?>
                                    <a href="#" class="ts_contact clear_fix write active">
                                    <span class="ts_contact_photo _online online" aria-label="онлайн">
                                        <img class="ts_contact_img" src="<?= $img; ?>/hHURe3JjcPQ.jpg?ava=1">
                                    </span>
                                        <span class="ts_contact_name float_left">
                                         <div class="ts_contact_title_wrap">
                                            <span class="ts_contact_title">Женя Алексеев</span>
                                         </div>
                                        <div class="ts_contact_info">ЧГУ им. Ульянова</div>
                                    </span>
                                        <div class="ts_contact_status"></div>
                                    </a>
                                <?php endfor; ?>

                                <div class="ts_search_sep">Результаты поиска</div>
                                <?php for($i = 1; $i <= rand(3, 5); $i++): ?>
                                    <a href="#" class="ts_contact clear_fix">
                                    <span class="ts_contact_photo _online">
                                        <img class="ts_contact_img" src="<?= $img; ?>/B6s_UC2rKaY.jpg?ava=1">
                                    </span>
                                        <span class="ts_contact_name float_left">
                                        <div class="ts_contact_title_wrap">
                                            <span class="ts_contact_title">ProgHub | <em class="ts_clist_hl">Сооб</em>щество топовых программистов</span>
                                        </div>

                                        <div class="ts_contact_info">Группа, 9<span class="num_delim"> </span>859 участников</div>
                                    </span>
                                        <div class="ts_contact_status"></div>
                                    </a>
                                <?php endfor?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>