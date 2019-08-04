<?php

use yii\helpers\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\PrerequisitesList;
?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_setting_selftest', 'Checking encore software prerequisites.'); ?>
    </div>
</div>

<div class="page_info_wrap">

    <?= PrerequisitesList::widget(); ?>

    <?= Html::a(Yii::t('AdminModule.views_setting_selftest', 'Re-Run tests'), Url::to(['prerequisites']), ['class' => 'btn btn-primary']); ?>
</div>
