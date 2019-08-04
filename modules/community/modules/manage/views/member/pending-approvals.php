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
                'request_message',
                [
                    'header' => Yii::t('CommunityModule.views_admin_members', 'Actions'),
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function() {
                            return;
                        },
                        'delete' => function($url, $model) use($community) {
                            return Html::a('Reject', $community->createUrl('reject-applicant', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-danger btn-sm', 'data-method' => 'POST']);
                        },
                                'update' => function($url, $model) use($community) {
                            return Html::a('Approve', $community->createUrl('approve-applicant', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-primary btn-sm', 'data-method' => 'POST']);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
        </div>
    </div>
</div>
