<?php
use \yii\helpers\Html;
?>

<h2 class="ui_block_h2 page_info_header_tabs">
    <ul class="ui_tabs clear_fix page_info_tabs">
        <?php foreach ($this->context->getItems() as $item): ?>
            <li <?= Html::renderTagAttributes($item['htmlOptions'])?>>
                <div class="ui_tab <?= $item['isActive'] ? 'ui_tab_sel' : ''; ?>" role="link">
                    <?= Html::a($item['label'], $item['url']); ?>
                </div>
            </li>
        <?php endforeach; ?>
        <div class="ui_tabs_slider _ui_tabs_slider" style="width: 92px; margin-left: 14px;"></div>
    </ul>
</h2>
