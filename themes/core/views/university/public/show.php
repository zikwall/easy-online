<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \zikwall\easyonline\modules\core\widgets\GridView;

/* @var $this zikwall\easyonline\components\View */
/* @var $searchModel \zikwall\easyonline\modules\university\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->setPageTitle('Университеты');
?>


<?= GridView::widget([
    'options' => ['class' => 'table-responsive'],
    'tableOptions' => ['class' => 'table table-condensed'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'id',
            'options' => ['width' => '100']
        ],
        'fullname:ntext',
        'shortname',
        'address:ntext',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}',
            'buttons' => [
                'view' => function ($url, $model) {
                    //$url = Url::to(['controller/lead-update', 'id' => $model->whatever_id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        'title' => Yii::t('FacultiesModule.base', 'Overview'),
                    ]);
                },

            ],
        ],

    ],
]); ?>
