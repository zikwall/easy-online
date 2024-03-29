<?php

use yii\bootstrap\Html;
use zikwall\easyonline\modules\core\widgets\GridView;

?>
<div class="panel-heading">
    <?= Yii::t('FriendshipModule.base', '<strong>Sent</strong> friend requests'); ?>
</div>


<?= \zikwall\easyonline\modules\user\modules\friendship\widgets\ManageMenu::widget(['user' => $user]); ?>

<div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'username',
            'profile.firstname',
            'profile.lastname',
            [
                'header' => 'Actions',
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function () {
                        return;
                    },
                    'view' => function () {
                        return;
                    },
                    'delete' => function($url, $model) {
                        return Html::a('Cancel', ['/friendship/request/delete', 'userId' => $model->id], ['class' => 'btn btn-danger btn-sm', 'data-method' => 'POST']);
                    },
                ],
            ]],
    ]);
    ?>

</div>



