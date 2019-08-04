<?php

use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-body">

        <div class="media">
            <a href="<?= $community->getUrl(); ?>" class="pull-left">
                <!-- Show community image -->
                <?= \zikwall\easyonline\modules\community\widgets\Image::widget([
                    'community' => $community,
                    'width' => 40,
                ]); ?>
            </a>
            <div class="media-body">
                <!-- show username with link and creation time-->
                <h4 class="media-heading"><a href="<?= $community->getUrl(); ?>"><?= Html::encode($community->displayName); ?></a> </h4>
                <h5><?= Html::encode($community->description); ?></h5>
            </div>
        </div>

    </div>
</div>
