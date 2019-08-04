<?php

/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 * @var $model \zikwall\easyonline\modules\university\models\University
 */

?>

<div class="help-block">
    Вся необходимая информация для связи
</div>
<div class="panel-body">
    <div data-toggle="tooltip" title="Юридический адрес">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Юридический адрес: </span>
        <span class="label label-primary"><?= $model->legal_address ?></span>
    </div>

    <div data-toggle="tooltip" title="Телефон">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Телефон: </span>
        <span class="label label-primary"><?= $model->telephone ?></span>
    </div>

    <div data-toggle="tooltip" title="Телефон ректора">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Телефон ректора: </span>
        <span class="label label-primary"><?= $model->rector_tepelhone ?></span>
    </div>

    <div data-toggle="tooltip" title="Эл.почта">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Эл.почта: </span>
        <span class="label label-primary"><?= $model->email ?></span>
    </div>

    <div data-toggle="tooltip" title="Факс">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Факс: </span>
        <span class="label label-primary"><?= $model->fax ?></span>
    </div>

    <div data-toggle="tooltip" title="Банковские реквизиты">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Банковские реквизиты: </span>
        <span class="label label-primary"><?= $model->bank_details ?></span>
    </div>

    <div data-toggle="tooltip" title="Интернет страница">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Интернет страница: </span>
        <span class="label label-primary"><?= $model->url ?></span>
    </div>

    <div data-toggle="tooltip" title="Почтовый адрес">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Почтовый адрес: </span>
        <span class="label label-primary"><?= $model->mail_address ?></span>
    </div>

    <div data-toggle="tooltip" title="Адрес">
        <span class="label label-default"><i class="fa fa-calendar-check-o fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Адрес: </span>
        <span class="label label-primary"><?= $model->address; ?></span>
    </div>
    <hr>
</div>

<?php //if ($model->chekAddress()):?>
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
<?php //endif; ?>

