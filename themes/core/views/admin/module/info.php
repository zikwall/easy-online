<?php
use yii\helpers\Html;
?>

<div class="markdown-render">
    <?php if ($content != ""): ?>
        <?= \yii\helpers\Markdown::process($content); ?>
    <?php else: ?>
        <?= $description; ?>
        <br>
        <br>
        <?= Yii::t('AdminModule.views_module_info', 'This module doesn\'t provide further informations.'); ?>
    <?php endif; ?>
</div>




