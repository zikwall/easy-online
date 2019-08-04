<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model zikwall\easyonline\modules\specialities\models\SpecialitiesProfiles */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('SpecialitiesModule.base', 'Specialities Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page_info_wrap">
    <div class="specialities-profiles-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('SpecialitiesModule.base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('SpecialitiesModule.base', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('SpecialitiesModule.base', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'shortname',
                'description:ntext',
                'created_at',
                'updated_at',
                'created_by',
                'updated_by',
            ],
        ]) ?>

    </div>
</div>
