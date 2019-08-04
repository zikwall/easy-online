<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\widgets\CommunityGridView;
?>

<h4><?= Yii::t('AdminModule.views_space_index', 'Overview'); ?></h4>
<div class="help-block">
    <?= Yii::t('AdminModule.views_space_index', 'This overview contains a list of each space with actions to view, edit and delete spaces.'); ?>
</div>

<div class="table-responsive">
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.space', 'Add new space'), ['/space/create'], ['class' => 'btn btn-success pull-right', 'data-target' => '#globalModal']); ?>
    <?php
    $visibilities = [
        Community::VISIBILITY_NONE => Yii::t('CommunityModule.base', 'Private (Invisible)'),
        Community::VISIBILITY_REGISTERED_ONLY => Yii::t('CommunityModule.base', 'Public (Visible)'),
        Community::VISIBILITY_ALL => 'All',
    ];

    $joinPolicies = [
        Community::JOIN_POLICY_NONE => Yii::t('CommunityModule.base', 'Only by invite'),
        Community::JOIN_POLICY_APPLICATION => Yii::t('CommunityModule.base', 'Invite and request'),
        Community::JOIN_POLICY_FREE => Yii::t('CommunityModule.base', 'Everyone can enter'),
    ];

    echo CommunityGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => '40px'],
                'format' => 'raw',
                'value' => function($data) {
                    return $data->id;
                },
            ],
            'name',
            [
                'attribute' => 'visibility',
                'filter' => \yii\helpers\Html::activeDropDownList($searchModel, 'visibility', array_merge(['' => ''], $visibilities)),
                'options' => ['width' => '40px'],
                'format' => 'raw',
                'value' => function($data) use ($visibilities) {
                    if (isset($visibilities[$data->visibility]))
                        return $visibilities[$data->visibility];
                        return Html::encode($data->visibility);
                    },
            ],
            [
                'attribute' => 'join_policy',
                'options' => ['width' => '40px'],
                'filter' => \yii\helpers\Html::activeDropDownList($searchModel, 'join_policy', array_merge(['' => ''], $joinPolicies)),
                'format' => 'raw',
                'value' => function($data) use ($joinPolicies) {
                    if (isset($joinPolicies[$data->join_policy]))
                        return $joinPolicies[$data->join_policy];
                        return Html::encode($data->join_policy);
                    },
            ],
            [
                'header' => Yii::t('AdminModule.views_space_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width' => '80px'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<i class="fa fa-eye"></i>', $model->getUrl(), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', $model->createUrl('/space/manage'), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<i class="fa fa-times"></i>', $model->createUrl('/space/manage/default/delete'), ['class' => 'btn btn-danger btn-xs tt']);
                    }
                ],
            ],
        ],
    ]);
    ?>
</div>
