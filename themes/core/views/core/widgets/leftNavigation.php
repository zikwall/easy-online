<?php if ($outerWrapper): ?>
    <div
    <?= $outerWrapperOptions['id'] ? 'id="'.$outerWrapperOptions['id'].'"' : ''; ?>
    <?= isset($outerWrapperOptions['class']) ? 'class="'.$outerWrapperOptions['class'].'"' : ''; ?>
    >
<?php endif; ?>
<style>
    .ui_ownblock {
        display: block;
        padding: 9px 15px;
    }
    .ui_ownblock_img {
        float: left;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .ui_ownblock_label, .ui_ownblock_hint {
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ui_ownblock_hint {
        color: #777e8c;
    }
</style>
<div class="page_block ui_rmenu ui_rmenu_pr" role="list" id="<?= $this->context->id; ?>">

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
            <?php elseif ($item['isOwnblock']): ?>
                <a class="ui_ownblock clear_fix" href="<?= $item['url']; ?>">
                    <img class="ui_ownblock_img" src="https://vk.com/images/deactivated_hid_200.gif">
                    <div class="ui_ownblock_info">
                        <div class="ui_ownblock_label"><?= $item['label']; ?></div>
                        <div class="ui_ownblock_hint"><?= $item['hint']; ?></div>
                    </div>
                </a>
            <?php else: ?>
                <?php
                $item['htmlOptions']['class'] .= " ui_rmenu_item";

                if ($item['isActive']) {
                    $item['htmlOptions']['class'] .= " ui_rmenu_item_sel";

                }?>

                <?php if (!empty($item['subItems'])): ?>
                    <div class=" ui_action_menu_item_sub">

                        <?= \yii\helpers\Html::a($item['icon']."<span>".$item['label']."</span>", $item['url'], $item['htmlOptions']); ?>

                        <div class="ui_actions_menu_wrap _ui_menu_wrap">
                            <div class="ui_actions_menu_icons" tabindex="0" aria-label="Действия" role="button">
                                <span class="blind_label">Действия</span>
                            </div>

                            <?php if (isset($item['subItems']) && is_array($item['subItems'])): ?>
                                <div class="ui_actions_menu _ui_menu">
                                    <?php foreach ($item['subItems'] as $subItem): ?>
                                    <a href="<?= $subItem['url']; ?>" <?= $subItem['id'] ? 'id=' . $subItem['id']: ''?> class="ui_actions_menu_item feedback_new_source">
                                        <?= $subItem['label']; ?>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <?= \yii\helpers\Html::a($item['icon']."<span>".$item['label']."</span>", $item['url'], $item['htmlOptions']); ?>
                <?php endif; ?>
            <?php endif; ?>

        <?php endforeach; ?>
    
    <?php endforeach; ?>

    <div class="ui_rmenu_slider _ui_rmenu_slider"></div>
</div>

<?php if ($outerWrapper): ?>
    </div>
<?php endif; ?>