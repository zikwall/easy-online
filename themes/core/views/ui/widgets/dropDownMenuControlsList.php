<div class="group_row_actions">
    <div class="ui_actions_menu_wrap _ui_menu_wrap groups_actions_menu _actions_menu">
        <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
            <span class="blind_label">Действия</span><div class="groups_actions_icons"></div>
        </div>
        <div class="ui_actions_menu _ui_menu">
            <?php foreach ($this->context->getItemGroups() as $group) : ?>
                <?php $items = $this->context->getItems($group['id']); ?>
                <?php if (count($items) == 0) continue; ?>

                <?php foreach ($items as $item) : ?>
                    <?php
                    $item['htmlOptions']['class'] .= ' ui_actions_menu_item';
                    $item['htmlOptions']['role'] = 'link';
                    $item['htmlOptions']['tabindex'] = '0';
                    ?>
                    <?= \yii\helpers\Html::a(
                        $item['label'], $item['url'], $item['htmlOptions']
                    ); ?>
                <?php endforeach; ?>

            <?php endforeach; ?>
        </div>
    </div>
</div>