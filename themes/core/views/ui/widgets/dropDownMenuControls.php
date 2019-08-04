<div class="page_actions_wrap unshown">
    <div class="page_actions_header">
        <span class="page_actions_header_inner">Меню</span>
    </div>
    <div class="page_actions_inner">

        <?php foreach ($this->context->getItemGroups() as $group) : ?>
            <?php $items = $this->context->getItems($group['id']); ?>
            <?php if (count($items) == 0) continue; ?>

            <?php foreach ($items as $item) : ?>
                <?php
                    $item['htmlOptions']['class'] .= ' page_actions_item';
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