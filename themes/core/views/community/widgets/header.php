<?php
/* @var $this \zikwall\easyonline\modules\core\components\base\View*/
/* @var $currentCommunity \zikwall\easyonline\modules\community\models\Community */

use zikwall\easyonline\modules\community\widgets\HeaderControlsMenu; ?>
<div class="page_block">
    <div class="page_cover crisp_image _page_cover" style="background-image: url(https://pp.userapi.com/c824603/v824603169/8d362/KglGM_S1q_s.jpg)"></div>
    <div class="page_cover_info clear_fix">
        <div class="page_cover_actions">
            <div id="public_actions_wrap" class="group_actions_wrap group_actions_wrap_redesign">
                <aside aria-label="Действия">
                    <div id="page_actions" class="page_actions" style="">
                        <div class="group_cta">
                            <a href="https://www.youtube.com/marveldcru">
                                <button class="flat_button button_wide">Перейти</button>
                            </a>
                        </div>
                        <div class="page_actions_wide clear_fix no_actions redesign">
                            <div class="page_action_left float_left">
                                <div id="page_actions_btn" class="flat_button button_wide secondary page_actions_btn" tabindex="0" role="button">
                                    <span class="page_actions_dd_label">Меню</span>
                                </div>

                                <?= zikwall\easyonline\modules\community\widgets\HeaderControlsMenu::widget([
                                    'community' => $community,
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <a class="page_cover_image" href="/photo-20629724_456249195">
            <img src="https://sun1-18.userapi.com/c847121/v847121550/8114a/_n9H1aYhSw8.jpg?ava=1" class="post_img">
        </a>
        <div class="page_top">
            <h2 class="page_name">Habr
                <a href="/verify" class="page_verified">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <g fill="none" fill-rule="evenodd">
                            <path fill="#74A2D6" d="M5.82331983,14.8223666 L4.54259486,15.0281417 C4.15718795,15.0900653 3.78122933,14.8730055 3.64215331,14.5082715 L3.17999726,13.2962436 C3.09635683,13.0768923 2.92310766,12.9036432 2.70375635,12.8200027 L1.49172846,12.3578467 C1.12699447,12.2187707 0.909934662,11.842812 0.971858288,11.4574051 L1.17763336,10.1766802 C1.21487428,9.94489615 1.15146068,9.70823338 1.00331709,9.52612299 L0.184748166,8.51987017 C-0.0615827221,8.21705981 -0.0615827221,7.78294019 0.184748166,7.48012983 L1.00331709,6.47387701 C1.15146068,6.29176662 1.21487428,6.05510385 1.17763336,5.82331983 L0.971858288,4.54259486 C0.909934662,4.15718795 1.12699447,3.78122933 1.49172846,3.64215331 L2.70375635,3.17999726 C2.92310766,3.09635683 3.09635683,2.92310766 3.17999726,2.70375635 L3.64215331,1.49172846 C3.78122933,1.12699447 4.15718795,0.909934662 4.54259486,0.971858288 L5.82331983,1.17763336 C6.05510385,1.21487428 6.29176662,1.15146068 6.47387701,1.00331709 L7.48012983,0.184748166 C7.78294019,-0.0615827221 8.21705981,-0.0615827221 8.51987017,0.184748166 L9.52612299,1.00331709 C9.70823338,1.15146068 9.94489615,1.21487428 10.1766802,1.17763336 L11.4574051,0.971858288 C11.842812,0.909934662 12.2187707,1.12699447 12.3578467,1.49172846 L12.8200027,2.70375635 C12.9036432,2.92310766 13.0768923,3.09635683 13.2962436,3.17999726 L14.5082715,3.64215331 C14.8730055,3.78122933 15.0900653,4.15718795 15.0281417,4.54259486 L14.8223666,5.82331983 C14.7851257,6.05510385 14.8485393,6.29176662 14.9966829,6.47387701 L15.8152518,7.48012983 C16.0615827,7.78294019 16.0615827,8.21705981 15.8152518,8.51987017 L14.9966829,9.52612299 C14.8485393,9.70823338 14.7851257,9.94489615 14.8223666,10.1766802 L15.0281417,11.4574051 C15.0900653,11.842812 14.8730055,12.2187707 14.5082715,12.3578467 L13.2962436,12.8200027 C13.0768923,12.9036432 12.9036432,13.0768923 12.8200027,13.2962436 L12.3578467,14.5082715 C12.2187707,14.8730055 11.842812,15.0900653 11.4574051,15.0281417 L10.1766802,14.8223666 C9.94489615,14.7851257 9.70823338,14.8485393 9.52612299,14.9966829 L8.51987017,15.8152518 C8.21705981,16.0615827 7.78294019,16.0615827 7.48012983,15.8152518 L6.47387701,14.9966829 C6.29176662,14.8485393 6.05510385,14.7851257 5.82331983,14.8223666 L5.82331983,14.8223666 Z"/>
                            <polyline stroke="#FFFFFF" stroke-width="1.6" points="4.755 8.252 7 10.5 11.495 6.005" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </a>
            </h2>
            <div class="page_current_info" id="page_current_info"><span class="current_text">НЛО с вами!</span></div>
        </div>
    </div>
</div>
