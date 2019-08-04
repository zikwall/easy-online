<?php
/* @var $this \yii\web\View */
/* @var $content string */

\zikwall\easyonline\themes\core\bundles\EncoreBundle::register($this);

?>
<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <title><?= strip_tags($this->pageTitle); ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php $this->head() ?>
        <script>
            window.sidebarEnabled = true;
        </script>
        <style>
            .ui_actions_menu_wrap.shown .ui_actions_menu {
                visibility: visible;
                opacity: 1;
                filter: none;
                display: block !important;
                top: 41px;
                pointer-events: auto;
            }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="page-container">
        <?= \zikwall\easyonline\modules\ui\widgets\HeaderMenu::widget(); ?>

        <div id="main-container" class="container">
            <?= \zikwall\easyonline\modules\ui\widgets\SidebarMenu::widget([]); ?>
            <div class="page-body">
                <?= $content; ?>
            </div>
        </div>
    </div>

    <script>
        window.onload = (e) => {
            //window.sidebarEnabled = true;

            $('.sidebar-left-settings').on('mouseover', (e) => {
                e.currentTarget.style.opacity = 1;
            }).on('mouseout', (e) => {
                e.currentTarget.style.opacity = 0;
            });

            var timer;

            const UI = {
                dropDownMenu: (options ={}) => {
                    let opt = {
                        dropSelector: null,
                        unDropSelector: null,
                        unDroppedSelector: null,
                        dropCallback: null,
                        unDropCallback: null,
                        unDropDroppedCallback: null,
                        isFirstClick: false
                    };

                    opt = {...options};

                    var timer;

                    $(opt.dropSelector).on(opt.isFirstClick ? 'click' : 'mouseover', () => {
                        opt.dropCallback(this);
                        console.log(111);
                    }).on('mouseleave', () => {
                        timer = setTimeout(() => {
                            opt.unDropCallback(this);
                        }, 500);

                        console.log(333);
                    });

                    $(opt.unDropSelector).on('mouseover', () => {
                        clearTimeout(timer);
                    }).on('mouseleave', () => {
                        opt.unDropDroppedCallback(this);
                        console.log(2221122331);
                    });
                },
            };

            $('.page_actions_btn').on('click', function() {
                $(this).parent()
                    .children('.page_actions_wrap')
                    .removeClass('unshown')
                    .addClass('toshown');

            }).on('mouseleave', function() {
                timer = setTimeout(() => {
                    $(this).parent()
                        .children('.page_actions_wrap')
                        .removeClass('toshown')
                        .addClass('unshown');
                }, 1000);
            });

            $('.page_actions_inner').on('mouseover', function() {
                clearTimeout(timer);
            }).on('mouseleave', function() {
                $(this).parent()
                    .removeClass('toshown')
                    .addClass('unshown');
            });

            var initActionMenu = false;

            $('.ui_actions_menu_icons').on('mouseover', function() {
                clearTimeout(timer);
                $(this).parent().addClass('shown');

                /*if (initActionMenu !== false && initActionMenu) {
                    initActionMenu.removeClass('shown');
                }

                initActionMenu = $(this).parent();*/

            }).on('mouseleave', function() {
                timer = setTimeout(() => {
                    $(this).parent().removeClass('shown');
                }, 500);
            });

            $('._ui_menu').on('mouseover', function() {
                clearTimeout(timer);
            }).on('mouseleave', function() {
                $(this).parent().removeClass('shown');
            });

            <?php if (Yii::$app->controller->action->id != 'global-alternative' || Yii::$app->controller->action->id != 'global'): ?>

            <?php endif; ?>

            <?php if (Yii::$app->controller->id == 'profile') :?>

            <?php endif; ?>

            <?php if (in_array(Yii::$app->controller->action->id, ['settings', 'modules'])) :?>
            let menu = new StickySidebar('#admin-menu', {
                containerSelector: '#main-container',
                innerWrapperSelector: '.ui_rmenu',
                topSpacing: 50,
            });
            <?php endif; ?>

            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).find('.modal-box-title-wrap').remove();
                let body = $(this).find('.modal-box-content');
                body.empty();
                body.append('<div class="loader encore-ui-loader">\n' +
                    '    <div class="sk-cube-grid">\n' +
                    '        <div class="sk-cube sk-cube1"></div>\n' +
                    '        <div class="sk-cube sk-cube2"></div>\n' +
                    '        <div class="sk-cube sk-cube3"></div>\n' +
                    '        <div class="sk-cube sk-cube4"></div>\n' +
                    '        <div class="sk-cube sk-cube5"></div>\n' +
                    '        <div class="sk-cube sk-cube6"></div>\n' +
                    '        <div class="sk-cube sk-cube7"></div>\n' +
                    '        <div class="sk-cube sk-cube8"></div>\n' +
                    '        <div class="sk-cube sk-cube9"></div>\n' +
                    '    </div>\n' +
                    '</div>');
            });
        };

        /*document.addEventListener("DOMContentLoaded", function() {
            OverlayScrollbars(document.querySelectorAll("body"), {
                className: 'os-theme-thin-dark'
            });
        });*/
    </script>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
