<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('AdminModule.views_space_index', '<strong>Manage</strong> spaces'); ?></div>
    <?= \zikwall\easyonline\modules\community\widgets\CommunityMenu::widget(); ?>
    <div class="panel-body">
        <h4><?= Yii::t('CommunityModule.spacetype', 'Space Types'); ?></h4>
        <div class="help-block">
            <?= Yii::t('CommunityModule.spacetype', 'Here you can manage your space types, which can be used to categorize your spaces.'); ?>
        </div>

        <p class="pull-right">
            <?= Html::a(Yii::t('CommunityModule.spacetype', "Create new type"), Url::toRoute('edit'), array('class' => 'btn btn-primary')); ?>
        </p>
        <br>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-hover'],
            'columns' => [
                'id',
                'title',
                'item_title',
                [
                    'attribute' => 'show_in_directory',
                    'value' =>
                    function($data) {
                        return ($data->show_in_directory == 1) ? 'Yes' : 'No';
                    }
                ],
                'sort_key',
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['width' => '80px'],
                    'buttons' => [
                        'update' => function($url, $model) {
                            return Html::a('<i class="fa fa-pencil"></i>', Url::to(['edit', 'id' => $model->id]), ['class' => 'btn btn-primary btn-xs tt']);
                        },
                                'view' => function() {
                            return;
                        },
                                'delete' => function() {
                            return;
                        },
                            ],
                        ],
                ]]);
                ?>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.grid-view-loading').show();
        $('.grid-view-loading').css('display', 'block !important');
        $('.grid-view-loading').css('opacity', '1 !important');
    });

</script>
