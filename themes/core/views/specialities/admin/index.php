<?php

use yii\helpers\Html;
use \zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel zikwall\easyonline\modules\specialities\models\search\UniversitySpecialitiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="page_info_wrap">
    <div class="specialities-index">

        <div class="help-block">
            Создавайте, редактируйте направления подготовки в пару кликов, легкий и функциональный интерфейс Вам в этом поможет!
        </div>
        <hr>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a(Yii::t('SpecialitiesModule.base', 'Create Specialities'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'id',
                    'contentOptions' => ['style' => 'width:30px; white-space: normal;'],
                    'header' => 'ID',
                ],
                [
                    'attribute' => 'faculty_id',
                    'value' => 'faculty.shortname',
                    'filter' => Html::activeDropDownList($searchModel, 'faculty_id', $searchModel->getFacultiesList(),['class'=>'form-control','prompt' => 'Факультет']),
                ],
                'fullname:ntext',
                'code',
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
                    'buttons' => [
                        'update' => function($url, $model) {
                            return Html::a('Редактировать', Url::toRoute(['update', 'id' => $model->id]), ['class' => '']);
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>


