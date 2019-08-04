<?php
use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;
wswsw
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.views_user_index', 'Add new user'), ['/user/admin/add'],
                ['class' => 'flat_button button_wide', 'data-ui-loader'=>'']); ?>
            <?= Html::a(
                    '<i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.views_user_index', 'Send invite'),
                    Url::to(['/user/invite']), ['class' => 'flat_button button_wide secondary', 'data-target' => '#globalModal', 'data-toggle'=>'modal',]
            ); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.user', 'Overview'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_user_index', 'This overview contains a list of each registered user with actions to view, edit and delete users.'); ?>
</div>

<div class="page_info_wrap">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width:40px;'],
                'format' => 'raw',
                'value' => function($data) {
                    return $data->id;
                },
            ],
            [
                'attribute' => 'username',
                'options' => ['style' => 'width:60px;'],
            ],
            'profile.firstname',
            'profile.lastname',
            /*[
                'attribute' => 'last_login',
                'label' => Yii::t('AdminModule.views_user_index', 'Last login'),
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'last_login',
                    'options' => ['style' => 'width:86px;', 'class' => 'form-control'],
                ]),
                'value' => function ($data) {
                    return ($data->last_login == NULL) ? Yii::t('AdminModule.views_user_index', 'never') : Yii::$app->formatter->asDate($data->last_login);
                }
            ],*/
            [
                'header' => 'Статистика',
                'format' => 'raw',
                'options' => ['style' => 'width:36px;', 'class' => 'form-control'],
                'value' => function ($item) {
                    return '<div class="user-stats-icon-wrap">
                                <a class="user-stats-icon" href="/'. $item->id . '" target="_blank" data-title="Статистика просмотров"></a>
                            </div>';
                }
            ],
            [
                'header' => Yii::t('AdminModule.views_user_index', 'Actions'),
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('Редактировать', Url::toRoute(['edit', 'id' => $model->id]), ['class' => '']);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
