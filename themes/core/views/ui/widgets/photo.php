<?php
$img = Yii::getAlias('@web') . '/resources/img';
?>
<div class="page_block page_photo">
    <div class="owner_photo_wrap" id="owner_photo_wrap">
        <div class="owner_photo_top_bubble_wrap">
            <div class="owner_photo_top_bubble">
                <div class="ui_thumb_x_button" onclick="" data-title="Удалить фотографию" tabindex="0" role="button" aria-label="Удалить фотографию">
                    <div class="ui_thumb_x"></div>
                </div>
            </div>
        </div>
        <div class="page_avatar_wrap no_stickers_1april" id="page_avatar_wrap">

            <aside aria-label="Фотография">
                <div id="page_avatar" class="page_avatar"><img class="page_avatar_img" src="<?= $img; ?>/ParU210PwrI.jpg?ava=1" alt="Андрей ———————————————————————————————————  &amp;#7584;&amp;#7608;&amp;#7580;&amp;#7503; &amp;#7527;&amp;#8338;&amp;#7524; ——————————————————————————————————— Капитонов" width="200" height="335"></div>
            </aside>
        </div>
        <div class="owner_photo_bubble_wrap">
            <div class="owner_photo_bubble">
                <div class="owner_photo_bubble_action owner_photo_bubble_action_update" onclick="" tabindex="0" role="button">
                    <span class="owner_photo_bubble_action_in">Обновить фотографию</span>
                </div>
                <div class="owner_photo_bubble_action owner_photo_bubble_action_crop" onclick="" tabindex="0" role="button">
                    <span class="owner_photo_bubble_action_in">Изменить миниатюру</span>
                </div>
            </div>
        </div>
    </div>
    <aside aria-label="Действия со страницей">
        <div class="profile_actions">
            <div class="profile_action_btn profile_msg_split" id="profile_message_send">
                <div class="clear_fix">
                    <a href="/write241233660" class="button_link cut_left">
                        <button class="flat_button profile_btn_cut_left">Сообщение</button>
                    </a>
                    <a href="#" class="button_link cut_right" id="profile_send_gift_btn">
                        <button class="flat_button profile_btn_cut_right">
                            <span class="profile_gift_icon"></span>
                            <span class="profile_gift_text">Отправить подарок</span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="page_actions_wide clear_fix edit">
                <div class="page_action_left float_left" style="display: inline-block; width: 75%; margin-right: 9px;">
                    <a id="profile_edit_act" href="edit" class="flat_button button_wide secondary in_profile">Редактировать</a>
                </div>
                <div style="display: inline-block; width: 20%;">
                    <a class="flat_button secondary button_wide page_actions_btn stats narrow float_right in_profile" href="/stats?mid=146677013" tabindex="0" role="button">&nbsp;</a>
                </div>
            </div>
        </div>
    </aside>
</div>