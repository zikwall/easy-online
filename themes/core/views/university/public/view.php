<?php


use \yii\helpers\Html;

/* @var $this zikwall\easyonline\components\View */
/* @var $model \zikwall\easyonline\modules\university\models\University */

$this->setPageTitle('Университеты - '.$model->fullname);
?>

<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-heading"><strong>Университеты</strong> обзор: <strong>"<?= $model->fullname; ?>"</strong></div>

        <div class="panel-body">
            <div class="help-block">
                На данной странице Вы сможете просмотреть всю информацию об университете, узнать адреса и просмотреть список факультетов
            </div>
            <div class="panel-body">
                <div data-toggle="tooltip" title="Просмотров">
                    <span class="label label-default"><i class="fa fa-dot-circle-o fa-fw" aria-hidden="true"></i></span>
                    <span class="label label-default">Просмотров: </span>
                    <span class="label label-primary">1080</span>
                </div>

                <div data-toggle="tooltip" title="Полное наименование">
                    <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
                    <span class="label label-default">Полное наименование: </span>
                    <span class="label label-primary"><?= $model->fullname ?></span>
                </div>

                <div data-toggle="tooltip" title="Адрес">
                    <span class="label label-default"><i class="fa fa-calendar-check-o fa-fw" aria-hidden="true"></i></span>
                    <span class="label label-default">Адрес: </span>
                    <span class="label label-primary"><?= $model->address; ?></span>
                </div>
                <hr>
            </div>

            <div class="panel-body">
                <p class="panel-heading"><strong>История</strong> университета:</p>
                <div class="panel-body">
                    <?= $model->getParsedContent(); ?>
                </div>
            </div>

            <div class="panel-body">
                <hr>
                <p class="panel-heading">
                   <?= Yii::t('UniversityModule.base', 'Faculties of this university (<strong>{university}</strong>)', ['university' => $model->shortname]);?>

                    <?= Yii::t('UniversityModule.base', '{n, plural, one{found # faculty} few{found # faculties} many{found # faculties} other{found # faculties}}', ['n' => count($model->universityFaculties)]); ?>
                    <?php if ($model->universityFaculties): ?>
                    <a class="dropdown-toggle"
                       title="<?= Yii::t('UniversityModule.base', 'Expand the list of faculties'); ?>"
                       onclick="$('#viewfaculties').slideToggle('fast');$('#viewfaculties').focus();return false;"
                       data-toggle="dropdown" href="#"
                       aria-label="<?= Yii::t('UniversityModule.base', 'Expand the list of faculties'); ?>
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-angle-down fa-fw"></i>
                    </a>
                    <?php endif; ?>
                </p>
                <div id="viewfaculties" style="display: none;">
                    <ul class="tour-list">
                        <?php foreach ($model->universityFaculties as $faculties): ?>
                            <li id="interface_entry" class="">
                                <?= Html::a('<i class="fa fa-chevron-right"></i> '.$faculties->fullname, ['/faculties/public/view-ajax', 'id' => $faculties->id], ['class' => '', 'data-target' => '#globalModal']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php if ($model->chekAddress()):?>
            <div class="panel-body">
                <p class="panel-heading"><?= Yii::t('UniversityModule.base', 'University location (<strong>{location}</strong>)', ['location' => $model->address_map]); ?>
                    <a class="dropdown-toggle"
                       title="<?= Yii::t('UniversityModule.base', 'Expand map'); ?>"
                       onclick="$('#viewmaplocation').slideToggle('fast');$('#viewmaplocation').focus();return false;"
                       data-toggle="dropdown" href="#"
                       aria-label="<?= Yii::t('UniversityModule.base', 'Expand map'); ?>
                       aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-angle-down fa-fw"></i>
                    </a>
                </p>
                <div class="panel-body">
                    <div id="viewmaplocation" style="display: none;">
                    <?php
                    $obj = new \zikwall\easyonline\modules\university\widgets\yandexmap\GeoObject([
                        'hintContent' => 'ssss',
                        'balloonContent' => 'wswsw',
                    ],[]);
                    $map = new \zikwall\easyonline\modules\university\widgets\yandexmap\Map('yandex_map', [
                        'center' => [$model->latitude, $model->longitude],
                        'zoom' => 10,
                        // Enable zoom with mouse scroll
                        'behaviors' => array('default', 'scrollZoom'),
                        'type' => "yandex#map",
                    ],
                        [
                            'objects' => [new \zikwall\easyonline\modules\university\widgets\yandexmap\objects\Placemark([$model->latitude, $model->longitude], [$obj], [
                                'draggable' => true,
                                'balloonContentFooterLayout' => 'ymaps.templateLayoutFactory.createClass(
                                население: $[properties.population], координаты: $[geometry.coordinates])',
                                // Отключаем задержку закрытия всплывающей подсказки.
                                'hintHideTimeout' => 0,
                                //'visible' => false,
                                'preset' => 'islands#blueHomeIcon',
                                'iconColor' => '#2E9BB9',
                                'events' => [
                                    'dragend' => 'js:function (e) {
                    console.log(e.get(\'target\').geometry.getCoordinates());
                }'
                                ]
                            ])]
                        ],
                        [
                            // Permit zoom only fro 9 to 11
                            'minZoom' => 9,
                            'maxZoom' => 11,
                            'controls' => [
                                "new ymaps.control.SmallZoomControl()",
                                "new ymaps.control.TypeSelector(['yandex#map', 'yandex#satellite'])",
                            ],
                        ]
                    );

                    echo \zikwall\easyonline\modules\university\widgets\yandexmap\Canvas::widget([
                        'htmlOptions' => [
                            'style' => 'height: 400px;',
                        ],
                        'map' => $map,

                    ]);
                    ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
