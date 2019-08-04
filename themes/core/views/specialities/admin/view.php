<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model zikwall\easyonline\modules\specialities\models\Specialities */

?>
<div class="page_info_wrap">
    <div class="specialities-view">

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
                'faculty_id',
                'fullname:ntext',
                'shortname',
                'code',
                [
                    'attribute' => 'profiles',
                    'label' => 'Профили подготовки',
                    'value' => function($model){
                        /** @var \zikwall\easyonline\modules\specialities\models\UniversitySpecialities $model */
                        foreach ($model->specialityProfiles as $profile){
                            $profiles[] = $profile->name;
                        }
                        return implode(', ', $profiles);
                    }
                ],
                'description:ntext',
                'created_at',
                'updated_at',
            ],
        ]) ?>

    </div>
</div>



