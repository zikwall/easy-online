<?php

/* @var $this yii\web\View */

$this->title = 'en-Core Semantic UI | Home';

?>
<style>
    .dev_page_block {
        padding: 25px 30px 30px;
    }
    .dev_page_block {
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        margin-bottom: 20px;
        color: #000;
    }
    .dev_joined_blocks .dev_page_block {
        float: left;
        box-sizing: border-box;
    }

    .dev_page_cont .wk_header {
        font-size: 1.46em;
        margin-bottom: 12px;
        font-weight: 400!important;
        -webkit-font-smoothing: subpixel-antialiased!important;
        -moz-osx-font-smoothing: auto!important;
    }
    .dev_page_cont .wk_header, .dev_page_cont .wk_sub_header, .dev_page_cont .wk_sub_sub_header {
        border-bottom: none;
        color: #000;
        text-align: start!important;
    }
    .wk_header, .wk_header i, .wk_sub_header, .wk_sub_header i, .wk_sub_sub_header, .wk_sub_sub_header i {
        text-align: left!important;
        font-style: normal!important;
    }
    .wk_header {
        font-size: 18px;
        font-weight: 700;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        margin-bottom: 5px;
        color: #222;
    }
    .dev_joined_blocks .dev_page_block:last-child {
        margin-left: 20px;
    }
    .dev_page_cont .wk_sub_header, .dev_page_cont .wk_sub_sub_header {
        font-weight: 700;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>

<div id="home-main-container" class="row">

    <div id="home-sream-container" class="col-md-9">
        <div class="dev_page_cont">
            <div class="dev_page_block">
                <a name="Документация"></a>
                <div role="heading" class="wk_header">Документация</div>
                На этой странице приведены ссылки на самые востребованные разделы документации API.
                <a name="Справочная информация"></a>>
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Общие руководства</div>
                <a name="[[access_token|Авторизация]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/access_token">Авторизация</a></div>
                В этом разделе представлено описание всех видов авторизации на базе протокола OAuth, поддерживаемых при работе с API ВКонтакте. <br>

                <a name="[[api_requests|Запросы к API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/api_requests">Запросы к API</a></div>
                Описание стандартной схемы формирования запроса, которая используется для вызова большинства методов. <br>

                <a name="[[upload_files|Загрузка файлов]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/upload_files">Загрузка файлов</a></div>
                Подробная информация о загрузке фотографий, аудио/видео, документов на сервера ВКонтакте средствами API. <br>

                <a name="[[publications|Публикация контента]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/publications">Публикация контента</a></div>
                Обзор всех способов распространения контента ВКонтакте. <a name="Специальные руководства"></a>
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>

            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Специальные руководства</div>
                <a name="[[callback_api|Callback API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/callback_api">Callback API</a></div>
                Руководство по использованию Callback API для работы с событиями в сообществе. <br>

                <a name="[[bizmessages_doc|API сообщений сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/bizmessages_doc">API сообщений сообществ</a></div> Д
                окументация об использовании API для сообщений сообществ. <br>

                <a name="[[vk_apps_docs|Сервисы VK Apps]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_apps_docs">Сервисы VK Apps</a></div> Руководство по созданию сервисов. <br>

                <a name="[[community_apps_docs|Приложения сообществ]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/community_apps_docs">
                        Приложения сообществ</a></div> Руководство по созданию приложений сообществ. <br>

                <a name="[[payments|Платежный API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/payments">Платежный API</a></div>
                Руководство по использованию платежной системы в приложениях на vk.com. <br>

                <a name="[[goods_docs|API для товаров]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/goods_docs">API для товаров</a></div>
                Руководство по использованию API для товаров. <br>

                <a name="[[openapi|Open API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/openapi">Open API</a></div>
                Библиотека для работы с API ВКонтакте из Javascript на внешних сайтах. <br>

                <a name="[[clientapi|Client API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/clientapi">Client API</a></div>
                Описание методов взаимодействия с интерфейсом ВКонтакте, которые доступны для Flash и iFrame-приложений. <br>

                <a name="[[using_longpoll|Работа с Long Poll сервером]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/using_longpoll">Работа с Long Poll сервером</a></div>
                Руководство по использованию long poll запросов для мгновенного получения обновлений.
            </div>
        </div>
    </div>

    <div id="home-right-sidebar-container" class="col-md-3 col-no-right-padding">
        <div id="home-right-sidebar">
            <div class="dev_page_block">
                <div role="heading" class="wk_header">Начало работы</div>
                <a name="[[first_guide|Знакомство с API]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/first_guide">Знакомство с API</a></div>
                <a name="[[ios_how_to_start|iOS]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/ios_how_to_start">iOS</a></div>
                <a name="[[android_how_to_start|Android]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/android_how_to_start">Android</a></div>
                <a name="[[wp_how_to_start|Windows Phone]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/wp_how_to_start">Windows Phone</a></div>
                <a name="[[vk_how_to_start|Встраиваемые приложения]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/vk_how_to_start">Встраиваемые приложения</a></div>
                <a name="[[web_how_to_start|Web]]"></a>
                <div class="wk_sub_header" role="heading"><a href="/dev/web_how_to_start">Web</a></div> <a name="Общие руководства"></a>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        let homeRightSidebar = new StickySidebar('#home-right-sidebar', {
            containerSelector: '#home-right-sidebar-container',
            innerWrapperSelector: '.home-right-sidebar',
            topSpacing: 56,
            bottomSpacing: 50
        });
    });
</script>

