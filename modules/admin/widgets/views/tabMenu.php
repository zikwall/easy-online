<?php

use \yii\helpers\Html;
?>

<ul class="nav nav-tabs">
    <?php foreach ($this->context->getItems() as $item) : ?>
        <li role="presentation" <?= Html::renderTagAttributes($item['htmlOptions'])?>>
            <?= Html::a($item['label'], $item['url']); ?>
        </li>
    <?php endforeach; ?>
</ul>