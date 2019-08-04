<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model zikwall\easyonline\modules\specialities\models\SpecialitiesProfiles */

$this->title = Yii::t('SpecialitiesModule.base', 'Update {modelClass}: ', [
        'modelClass' => 'Specialities Profiles',
    ]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('SpecialitiesModule.base', 'Specialities Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('SpecialitiesModule.base', 'Update');
?>

<div class="page_info_wrap">
    <div class="specialities-profiles-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>

