<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \zikwall\easyonline\modules\user\permissions\ViewAboutPage;

$img = Yii::getAlias('@web') . '/resources/img';
?>

<?php if ($_GET['header'] == '1'): ?>
<style>
    .page_cover {
        height: 200px;
        border-radius: 4px 4px 0 0;
        background-position: 50%;
        background-size: cover;
    }
    .crisp_image {
        image-rendering: -o-crisp-edges;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: optimize-contrast;
        -ms-interpolation-mode: nearest-neighbor;
    }
    .page_cover_info {
        padding: 12px 15px;
    }
    page_cover_actions {
        float: right;
        padding: 8px 5px;
    }
    .group_actions_wrap {
        position: relative;
    }
    .page_cover_image {
        position: relative;
        float: left;
        height: 46px;
        width: 46px;
        margin-right: 7px;
    }
    .page_cover_info .post_img {
        height: 46px;
        width: 46px;
    }
    .post_img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        vertical-align: top;
    }
</style>

    <div class="page_block">
        <div class="page_cover crisp_image _page_cover" style="background-image: url(https://pp.userapi.com/c824603/v824603169/8d362/KglGM_S1q_s.jpg)"></div>
        <div class="page_cover_info clear_fix">
            <div class="page_cover_actions">
                <div id="public_actions_wrap" class="group_actions_wrap group_actions_wrap_redesign"></div>
            </div>
            <a class="page_cover_image" href="/photo-20629724_456249195">
                <img src="https://sun1-18.userapi.com/c847121/v847121550/8114a/_n9H1aYhSw8.jpg?ava=1" class="post_img">
            </a>
            <div class="page_top">

                <h2 class="page_name">Habr<a href="/verify" class="page_verified"></a></h2>
                <div class="page_current_info" id="page_current_info"><span class="current_text">НЛО с вами!</span></div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="wide_column_wrap">
    <div class="wide_column" id="wide_column">
        <div class="page_block">

            <?= \zikwall\easyonline\modules\ui\widgets\ExampleTabs::widget(); ?>

            <div id="page_info_wrap" class="page_info_wrap ">

                <?php if ($_GET['header'] != '1'): ?>
                    <div class="page_top">
                        <div class="_profile_online profile_online is_online">
                            <div class="profile_online_lv">Online
                                <b class="mob_onl profile_mob_onl unshown" id="profile_mobile_online"></b>
                            </div>
                        </div>

                        <h2 class="page_name"><?= $user->displayName; ?></h2>
                        <div class="page_current_info" id="page_current_info">
                            <div id="currinfo_editor" class="page_status_editor clear"></div>
                            <div id="currinfo_wrap" tabindex="0" role="button">
                                        <span id="current_info" class="current_info">
                                             <span class="my_current_info">
                                                  <span class="current_text">
                                                      <img class="emoji" alt="⃣" src="<?= $img; ?>/003220E3.png">
                                                      <img class="emoji" alt="⃣" src="<?= $img; ?>/003220E3.png"> :
                                                      <img class="emoji" alt="⃣" src="<?= $img; ?>/003220E3.png">
                                                      <img class="emoji" alt="⃣" src="<?= $img; ?>/003220E3.png">                               
                                              </span>
                                        </span>
                                 </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="profile_info profile_info_short" id="profile_short">
                    <div class="clear_fix profile_info_row ">
                        <div class="label float_left">
                            День рождения:
                        </div>
                        <div class="labeled">
                            <a href="/search?c[section]=people&amp;c[bday]=2&amp;c[bmonth]=7">2 июля</a>
                            <span id="vk_age_info"> (Рак, <span id="vk_calc_age_el">
                                        <a href="#">
                                            ? года
                                        </a>
                                    </span>)
                                    </span>
                        </div>
                    </div>
                    <div class="clear_fix profile_info_row ">
                        <div class="label float_left">Город:</div>
                        <div class="labeled">
                            <a href="/search?c[name]=0&amp;c[section]=people&amp;c[country]=1&amp;c[city]=790">Канаш</a>
                        </div>
                    </div>
                    <div class="clear_fix profile_info_row ">
                        <div class="label float_left">Место работы:</div>
                        <div class="labeled">
                            <a href="/io.blitz">I/O</a>
                        </div>
                    </div>
                    <div class="clear_fix profile_info_row ">
                        <div class="label float_left">Веб-сайт:</div>
                        <div class="labeled">
                            <a href="https://github.com/zikwall" target="_blank">https://github.com/zikwall</a>
                        </div>
                    </div>
                    <div id="relations_wrap"><div class="clear_fix profile_info_row ">
                            <div class="label float_left">Родители:</div>
                            <div class="labeled">
                                <div class="relation_request">
                                    <div class="progress" id="relation_progress498087692"></div>
                                    <a class="mem_link" href="/id498087692">Павел Григорьев</a>
                                    <small>(<a>принять</a><span class="divide">|</span><a>отклонить</a>)</small>
                                </div>
                            </div>
                        </div>
                        <div class="clear_fix profile_info_row ">
                            <div class="label float_left">Брат:</div>
                            <div class="labeled"><a class="mem_link" href="/ilya_and_ilya">Илья Васильев</a></div>
                        </div>
                    </div>
                    <div class="clear_fix profile_info_row ">
                        <div class="label float_left">Дата регистрации:</div>
                        <div class="labeled labeled_date_reg">12 сентября 2011 (15:16)</div>
                    </div>
                </div>

                <?php if ($user->permissionManager->can(new ViewAboutPage())): ?>
                    <div class="profile_more_info">
                        <a class="profile_more_info_link" onclick="$('#profile_full').slideToggle('fast');$('#profile_full').focus();return false;" >
                            <span class="profile_label_more">Показать подробную информацию</span>
                            <span class="profile_label_less">Скрыть подробную информацию</span>
                        </a>
                    </div>

                    <div class="profile_info profile_info_full" id="profile_full">

                        <?php foreach ($user->profile->getProfileFieldCategories() as $category): ?>
                            <div class="profile_info_block clear_fix" id="#profile-category-<?= $category->id; ?>">
                                <div class="profile_info_header_wrap">
                                    <a class="profile_info_edit" href="/edit">Редактировать</a>
                                    <span class="profile_info_header">
                                <?= Html::encode(Yii::t($category->getTranslationCategory(), $category->title)); ?>
                            </span>
                                </div>
                                <div class="profile_info">
                                    <?php foreach ($user->profile->getProfileFields($category) as $field) : ?>
                                        <div class="clear_fix profile_info_row ">
                                            <div class="label float_left">
                                                <?= Html::encode(Yii::t($field->getTranslationCategory(), $field->title)); ?>:
                                            </div>
                                            <div class="labeled">
                                                <a href="#"><?= $field->getUserValue($user, false); ?></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="counts_module">
                <?php if ($followingEnabled): ?>
                <a class="page_counter" href="<?= $user->createUrl('/user/profile/follower-list'); ?>" data-target="#globalModal">
                    <div class="count"><?= $countFollowers; ?></div>
                    <div class="label"><?= Yii::t('UserModule.widgets_views_profileHeader', 'Following'); ?></div>
                </a>
                <?php endif; ?>

                <?php if ($friendshipsEnabled): ?>
                <a class="page_counter" <?= Url::to(['/user/friendship/list/popup', 'userId' => $user->id]); ?>" data-target="#globalModal">
                    <div class="count"><?= $countFriends; ?></div>
                    <div class="label"><?= Yii::t('UserModule.widgets_views_profileHeader', 'Friends'); ?></div>
                </a>
                <?php endif; ?>

                <a class="page_counter" href="/albums146677013?profile=1">
                    <div class="count">141</div>
                    <div class="label">фотография</div>
                </a>
                <a class="page_counter" href="/tag146677013">
                    <div class="count">3</div>
                    <div class="label">отметки</div>
                </a>
                <a class="page_counter" href="/videos146677013">
                    <div class="count">210</div>
                    <div class="label">видеозаписей</div>
                </a>
                <a class="page_counter" href="/audios146677013">
                    <div class="count">254</div>
                    <div class="label">аудиозаписи</div>
                </a>
            </div>
        </div>
    </div>
</div>



