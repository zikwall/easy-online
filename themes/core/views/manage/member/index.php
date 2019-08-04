<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\GridView;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\modules\manage\widgets\MemberMenu;
?>

<div class="page_block">
    <?= MemberMenu::widget(['community' => $community]); ?>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('CommunityModule.views_admin_members', '<strong>Manage</strong> members'); ?>
        </div>
    </div>

    <div class="page_info_wrap">
        <div class="table-responsive">

            <?php
            $groups = $community->getUserGroups();
            unset($groups[Community::USERGROUP_OWNER], $groups[Community::USERGROUP_GUEST], $groups[Community::USERGROUP_USER]);

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'user.username',
                    'user.profile.firstname',
                    'user.profile.lastname',
                    [
                        'label' => Yii::t('CommunityModule.views_admin_members', 'Role'),
                        'class' => \zikwall\easyonline\modules\core\libs\DropDownGridColumn::class,
                        'attribute' => 'group_id',
                        'submitAttributes' => ['user_id'],
                        'readonly' => function ($data) use ($community) {
                            if ($community->isCommunityOwner($data->user->id)) {
                                return true;
                            }
                            return false;
                        },
                        'filter' => $groups,
                        'dropDownOptions' => $groups,
                        'value' =>
                            function ($data) use (&$groups, $community) {
                                return $groups[$data->group_id];
                            }
                    ],
                    [
                        'attribute' => 'last_visit',
                        'format' => 'raw',
                        'value' =>
                            function ($data) use (&$groups) {
                                if ($data->last_visit == '') {
                                    return Yii::t('CommunityModule.views_admin_members', 'never');
                                }

                                return \zikwall\easyonline\modules\core\widgets\TimeAgo::widget(['timestamp' => $data->last_visit]);
                            }
                    ],
                    [
                        'header' => Yii::t('CommunityModule.views_admin_members', 'Actions'),
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function () {
                                return;
                            },
                            'delete' => function ($url, $model) use ($community) {
                                if ($community->isCommunityOwner($model->user->id) || Yii::$app->user->id == $model->user->id) {
                                    return;
                                }
                                return Html::a(Yii::t('CommunityModule.views_admin_members', 'Remove'), $community->createUrl('remove', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-danger btn-sm', 'data-method' => 'POST', 'data-confirm' => 'Are you sure?']);
                            },
                            'update' => function () {
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
