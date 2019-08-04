<?php


use yii\helpers\Html;
use zikwall\easyonline\widgets\GridView;
use zikwall\easyonline\modules\community\modules\manage\widgets\MemberMenu;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('CommunityModule.views_admin_members', '<strong>Manage</strong> members'); ?>
    </div>
    <?= MemberMenu::widget(['community' => $community]); ?>
    <div class="panel-body">
        <div class="table-responsive">
            <?php
            $groups = $community->getUserGroups();


            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'user.username',
                    'user.profile.firstname',
                    'user.profile.lastname',
                    [
                        'attribute' => 'last_visit',
                        'format' => 'raw',
                        'value' =>
                        function($data) use(&$groups) {
                            return zikwall\easyonline\widgets\TimeAgo::widget(['timestamp' => $data->last_visit]);
                        }
                            ],
                            [
                                'header' => Yii::t('CommunityModule.views_admin_members', 'Actions'),
                                'class' => 'yii\grid\ActionColumn',
                                'buttons' => [
                                    'view' => function() {
                                        return;
                                    },
                                    'delete' => function($url, $model) use($community) {
                                        return Html::a('Cancel', $community->createUrl('remove', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-danger btn-sm', 'data-confirm' => 'Are you sure?', 'data-method' => 'POST']);
                                    },
                                            'update' => function() {
                                        return;
                                    },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
        </div>
    </div>
</div>
