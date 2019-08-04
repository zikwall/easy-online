<?php

use \yii\helpers\Html;
?>
<ul id="tabs" class="nav nav-tabs tab-sub-menu">
    <?php foreach ($this->context->getItems() as $item) {?>
        <li <?= Html::renderTagAttributes($item['htmlOptions'])?>>
        <?= Html::a($item['label'], $item['url']); ?>
    </li>
    <?php }; ?>
</ul>
