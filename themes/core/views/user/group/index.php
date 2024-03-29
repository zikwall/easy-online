<?php

use yii\helpers\Url;
use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\GridView;

?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.views_groups_index', "Create new community"), Url::to(['edit']), ['class' => 'btn btn-success']); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_group_index', 'Manage groups'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_groups_index', 'Users can be assigned to different groups (e.g. teams, departments etc.) with specific standard spaces, community managers and permissions.'); ?>
</div>

<div class="page_info_wrap">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
            'name',
            'description',
            [
                'attribute' => 'members',
                'label' => Yii::t('AdminModule.views_group_index', 'Members'),
                'format' => 'raw',
                'options' => ['style' => 'text-align:center;'],
                'value' => function ($data) {
                    return $data->getGroupUsers()->count();
                }
            ],
            [
                'header' => Yii::t('AdminModule.views_group_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width' => '80px'],
                'buttons' => [
                    'view' => function() {
                        return;
                    },
                    'delete' => function() {
                        return;
                    },
                    'update' => function($url, $model) {
                        return Html::a('<i class="fa fa-pencil"></i>', Url::toRoute(['edit', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>


