<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a(Yii::t('CommunityModule.spacetype', "Create new type"), Url::toRoute('edit'),
               ['class' => 'flat_button button_wide secondary']); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_space_index', '<strong>Manage</strong> spaces'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?php echo Yii::t('CommunityModule.spacetype', 'Here you can manage your space types, which can be used to categorize your spaces.'); ?>
</div>

<div class="page_info_wrap">
    <?= GridView::widget([
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
                        return Html::a('Редактировать', Url::to(['edit', 'id' => $model->id]), ['class' => '']);
                    },
                ],
            ],
        ]]);
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.grid-view-loading').show();
        $('.grid-view-loading').css('display', 'block !important');
        $('.grid-view-loading').css('opacity', '1 !important');
    });

</script>
