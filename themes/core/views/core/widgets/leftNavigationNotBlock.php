<style>
    .ui_ownblock {
        display: block;
        padding: 9px 15px;
    }
    .ui_ownblock_info {
        white-space: nowrap;
        font-size: 12.5px;
        line-height: 16px;
    }
    .ui_rmenu_sep {
        border-top: 1px solid rgb(231, 232, 236);
        margin: 6px 15px;
    }
</style>
<div class="ui_rmenu ui_rmenu_pr" role="list" id="<?= $this->context->id; ?>">

    <?php foreach ($this->context->getItemGroups() as $group) : ?>
        <?php $items = $this->context->getItems($group['id']); ?>
        <?php if (count($items) == 0) continue; ?>

        <?php if ($group['label'] != "") : ?>
            <div class="ui_ownblock clear_fix" href="">
                <div class="ui_ownblock_info">
                    <div class="ui_ownblock_label"><?= $group['label']; ?></div>
                </div>
            </div>
            <div class="ui_rmenu_sep"></div>
        <?php endif; ?>

        <?php foreach ($items as $item) : ?>

            <?php if ($item['label'] == '---'): ?>
                <div class="ui_rmenu_sep"></div>
            <?php else: ?>
                <?php
                $item['htmlOptions']['class'] .= " ui_rmenu_item";

                if ($item['isActive']) {
                    $item['htmlOptions']['class'] .= " ui_rmenu_item_sel";
                }
                ?>
                <?= \yii\helpers\Html::a($item['icon']."<span>".$item['label']."</span>", $item['url'], $item['htmlOptions']); ?>
            <?php endif; ?>

        <?php endforeach; ?>
    
    <?php endforeach; ?>

    <div class="ui_rmenu_slider _ui_rmenu_slider"></div>
</div>
