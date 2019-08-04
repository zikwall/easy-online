<?php /** @var $this \yii\web\View */ ?>
<?php $this->beginContent('@easyonline/modules/schedule/views/layouts/_advancedLayoutForSchedule.php') ?>

<?php

use yii\helpers\Html;
use \zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel zikwall\easyonline\modules\schedule\models\search\ScheduleAviableDay */
/* @var $dataProvider yii\data\ActiveDataProvider */
/**
 * @var \zikwall\easyonline\modules\faculties\models\UniversityFaculties $model
 */
?>
<div class="schedule-aviable-day-index">

    <?php /*// echo $this->render('_search', ['model' => $searchModel]); */?>

    <p>
        <?/*= Html::a(Yii::t('ScheduleModule.base', 'Create ScheduleHelper ScheduleHelper'), ['create'], ['class' => 'btn btn-success']) */?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'header' => 'День',
                'options' => ['style' => 'width:40px;'],
            ],
            [
                'attribute' => 'day.name',
                'header' => 'День'
            ],
            [
                'attribute' => 'couple.displayName',
                'header' => 'Пара'
            ],
            [
                'attribute' => 'teacher.user.displayName',
                'header' => 'Препод'
            ],
            'discipline.name',
            [
                'attribute' => 'studyGroup.displayName'
            ],
            // 'type_id',
            // 'en_name',
            // 'desc',

            [
                'header' => Yii::t('AdminModule.views_user_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width:80px; min-width:80px;'],
                'buttons' => [
                   /* 'view' => function($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', Url::toRoute(['view', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },*/
                    'update' => function($url, $model) {
                        return Html::a('Редактировать', Url::toRoute(['update', 'id' => $model->id]));
                    },
                    /*'delete' => function($url, $model) {
                        return Html::a('<i class="fa fa-times"></i>', Url::toRoute(['delete', 'id' => $model->id]), ['class' => 'btn btn-danger btn-xs tt']);
                    }*/
                ],
            ],
        ],
    ]); ?>
</div>

<?php $this->endContent(); ?>
