<?php

use yii\helpers\Html;
use \zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel zikwall\easyonline\modules\specialities\models\SpecialitiesProfilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('SpecialitiesModule.base', 'Specialities Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="encore-help-block">
    Создавайте, редактируйте профили направлений подготовки в пару кликов, легкий и функциональный интерфейс Вам в этом поможет!
</div>

<div class="page_info_wrap">
    <p>
        <?= Html::a(Yii::t('SpecialitiesModule.base', 'Create Specialities Profiles'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            [
                'attribute' => 'color',
                'value' => function($item){
                    return '<span class="label" style="background-color:'.$item->color.'!important;">' . $item->color . '</span>';
                },
                'format' => 'html',
            ],

            [
                'header' => Yii::t('AdminModule.views_user_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:80px; min-width:80px;'],
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('Редактировать', Url::toRoute(['update', 'id' => $model->id]), ['class' => '']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

