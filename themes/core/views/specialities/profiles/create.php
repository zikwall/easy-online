<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model zikwall\easyonline\modules\specialities\models\SpecialitiesProfiles */

$this->title = Yii::t('SpecialitiesModule.base', 'Create Specialities Profiles');
$this->params['breadcrumbs'][] = ['label' => Yii::t('SpecialitiesModule.base', 'Specialities Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page_info_wrap">
    <div class="specialities-create">

        <div class="specialities-profiles-create">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>
</div>


