<?php
$items = [
    'Моя страница',
    'Новости',
    'Сообщения',
    'Друзья',
    'Группы',
    'Фотографии',
    'Музыка',
    'Видео',
    'Игры',
    'VK Pay',
    'Товары',
    'Документы',
    'Управление'
];
$counts = [

];
?>
<div id="sidebar" class="sidebar float_left" style="top: 0px;">
    <div id="sidebar-inner" class="sidebar-inner">
        <nav>
            <ol>
                <?php for($i = 0; $i <= 20; $i++): ?>
                    <li id="l_pr" class="">
                        <a href="/id.kapitonov" class="sidebar-left-row">
                        <span class="sidebar-left-fixer">
                            <?php if (in_array($i, [rand(1, 4), rand(2, 7), rand(1, 9)])): ?>
                                <span class="sidebar-right-counter-wrap float_right">
                                    <span class="sidebar-inline-bl sidebar-right-count">
                                        <?php
                                        $counts = array_merge($counts, [rand(1, 999), rand(11, 888)]);
                                        ?>
                                        <?= $counts[array_rand($counts)]; ?>
                                    </span>
                                </span>
                            <?php endif; ?>
                            <span class="sidebar-left-icon float_left"></span>
                                <span class="sidebar-left-label sidebar-inline-bl"><?= $items[array_rand($items)];?></span>
                        </span>
                        </a>
                        <div class="sidebar-left-settings">
                            <div class="sidebar-left-settings-inner"></div>
                        </div>
                    </li>
                <?php endfor; ?>
                <li id="l_msd" class="">
                    <a href="/im" class="sidebar-left-row">
                        <span class="sidebar-left-fixer">
                            <span class="sidebar-right-counter-wrap float_right"><span class="sidebar-inline-bl sidebar-right-count">13</span></span>
                            <span class="sidebar-left-icon float_left"></span>
                            <span class="sidebar-left-label sidebar-inline-bl">Сообщения</span>
                        </span>
                    </a>
                    <div class="sidebar-left-settings" onclick="menuSettings(0)">
                        <div class="sidebar-left-settings-inner"></div>
                    </div>
                </li>
                <li id="l_apm" class="">
                    <a href="/apps?act=manage" class="sidebar-left-row">
                            <span class="sidebar-left-fixer">
                                <span class="sidebar-right-counter-wrap float_right left_void" style="opacity: 1; display: block;">
                                    <span class="sidebar-inline-bl sidebar-right-count_sign">
                                    </span>
                                </span>
                                <span class="sidebar-left-icon float_left"></span>
                                <span class="sidebar-left-label sidebar-inline-bl">Управление</span>
                            </span>
                    </a>
                    <div class="sidebar-left-settings">
                        <div class="sidebar-left-settings-inner"></div>
                    </div>
                </li>
                <div class="more_div"></div>
                <li id="l_mgid127730759" class="l_comm">
                    <a href="/profchgu" class="sidebar-left-row">
                        <span class="sidebar-left-fixer">
                            <object type="internal/link">
                                <a href="gim127730759" class="sidebar-right-counter-wrap float_right sidebar-right-counter-wrap-hovered">
                                    <span class="sidebar-inline-bl sidebar-right-count">17</span>
                                </a>
                            </object>
                            <span class="sidebar-left-icon float_left"></span>
                            <span class="sidebar-left-label sidebar-inline-bl"></i>Центр профориен..</span>
                        </span>
                    </a>
                    <div class="sidebar-left-settings">
                        <div class="sidebar-left-settings-inner"></div>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="more_div"></div>
        <div class="left_menu_nav_wrap">
            <a class="left_menu_nav" href="/blog">Блог</a>
            <a class="left_menu_nav" href="/dev">Разработчикам</a>
            <a class="left_menu_nav" href="/biz">Реклама</a>

            <div class="ui_actions_menu_wrap _ui_menu_wrap sdhown"
                 onmouseover=""
                 onmouseout="">

                <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
                    <span class="blind_label">Действия</span>
                    <a class="left_menu_nav left_menu_more" id="left_menu_more">Ещё</a>
                </div>
                <div class="ui_actions_menu _ui_menu">
                    <a class="ui_actions_menu_item" href="/about">О компании</a>
                    <a class="ui_actions_menu_item" href="/jobs">Вакансии</a>
                    <a class="ui_actions_menu_item" href="/legal">Правовая информация</a>
                    <a class="ui_actions_menu_item" href="/data_protection">Защита данных</a>
                    <a class="ui_actions_menu_item" href="/safety">Центр безопасности</a>
                    <a class="ui_actions_menu_item" tabindex="0" role="link">Язык: русский</a>
                </div>
            </div>
        </div>
    </div>
</div>