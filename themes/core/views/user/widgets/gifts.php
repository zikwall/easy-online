<?php
$img = Yii::getAlias('@web') . '/resources/img';
?>

<div class="page_block">
    <aside aria-label="Подарки">
        <div class="module clear profile_gifts _module" id="profile_gifts_<?= $i; ?>">
            <div class="header_right_link float_right"></div>
            <a href="/gifts146677013" onclick="" class="module_header">
                <div class="header_top clear_fix">
                    <span class="header_label float_left">Подарки</span>
                    <span class="header_count float_left" id="gifts_module_count"><?= rand(254, 543); ?></span>
                </div>
            </a>
            <div class="module_body clear_fix">
                <a href="/gifts146677013" class="profile_gifts_cont">
                    <img width="58" height="58" class="profile_gift_img" src="<?= $img; ?>/96.png" alt="ВКонтакте 12 лет">
                    <img width="58" height="58" class="profile_gift_img" src="<?= $img; ?>/96.png" alt="ВКонтакте 12 лет">
                    <img width="58" height="58" class="profile_gift_img" src="<?= $img; ?>/96.png" alt="ВКонтакте 12 лет">
                </a>
            </div>
        </div>
    </aside>
</div>
