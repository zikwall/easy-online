<?php

use \yii\helpers\Html;

?>

<div class="more_div"></div>
<div class="left_menu_nav_wrap">
    <?php $count = 1; $hiddens = []; foreach ($this->context->getItems() as $item): ?>
        <?php if ($item['label'] == '---'): continue; endif; ?>
        <?php if ($count <= 3): ?>
            <a class="left_menu_nav" href="<?= $item['url']; ?>"><?= $item['label']; ?></a>
        <?php else: ?>
            <?php $hiddens[] = $item; ?>
        <?php endif; ?>
    
    <?php $count++; endforeach; ?>
    
    <div class="ui_actions_menu_wrap _ui_menu_wrap">

        <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
            <span class="blind_label">Действия</span>
            <a class="left_menu_nav left_menu_more" id="left_menu_more">Ещё</a>
        </div>

        <div class="ui_actions_menu _ui_menu">
            <?php foreach ($hiddens as $hidden): ?>
                <a class="ui_actions_menu_item" href="<?= $hidden['url']; ?>"><?= $hidden['label']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>


