<?php
use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\widgets\CommunityGridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.space', 'Add new space'),
                ['/community/create'], ['class' => 'flat_button button_wide secondary', 'data-target' => '#globalModal', 'data-toggle'=>'modal',]); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_space_index', '<strong>Manage</strong> spaces'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_space_index', 'This overview contains a list of each space with actions to view, edit and delete spaces.'); ?>
</div>

<div class="page_info_wrap">
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
    ?>

    <?=
    CommunityGridView::widget([
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
            /*[
                'attribute' => 'join_policy',
                'options' => ['width' => '40px'],
                'filter' => \yii\helpers\Html::activeDropDownList($searchModel, 'join_policy', array_merge(['' => ''], $joinPolicies)),
                'format' => 'raw',
                'value' => function($data) use ($joinPolicies) {
                    if (isset($joinPolicies[$data->join_policy]))
                        return $joinPolicies[$data->join_policy];
                    return Html::encode($data->join_policy);
                },
            ],*/
            [
                'header' => 'Просмотр',
                'format' => 'raw',
                'options' => ['style' => 'width:36px;', 'class' => 'form-control'],
                'value' => function ($item) {
                    return '<div class="user-stats-icon-wrap">' .
                        Html::a('', $item->getUrl(), [
                                'class' => 'user-stats-icon', 'target' => '_blank', 'data-title' => 'Просмотр сообщества'])
                     . ' </div>';
                }
            ],
            [
                'header' => Yii::t('AdminModule.views_space_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width' => '80px'],
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('Редактировать', $model->createUrl('/community/manage'), ['class' => '']);
                        },
                ],
            ],
        ],
    ]);
    ?>
</div>
