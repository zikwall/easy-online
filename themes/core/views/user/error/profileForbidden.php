<style>

</style>
<div class="row">
    <div class="col-md-3">
        <div class="page_block page_photo">
            <div class="page_avatar_wrap" id="page_avatar_wrap">
                <aside aria-label="Фотография">
                    <div id="page_avatar" class="page_avatar">
                        <img class="page_avatar_img" src="https://vk.com/images/deactivated_hid_200.gif">
                    </div>
                </aside>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-no-right-padding">
        <div class="page_block">
            <div id="page_info_wrap" class="page_info_wrap">
                <div id="profile_info">
                    <div class="page_top">
                        <h2 class="page_name"><?= $user->displayName; ?></h2>
                        <div class="page_current_info">Страница скрыта</div>
                    </div>
                    <h5 class="profile_deleted_text"><?= $message; ?></h5>
                </div>
            </div>
        </div>
    </div>
</div>
