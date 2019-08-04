<div class="page_block">
    <div id="page_block_community_submain_info">
        <h2 class="page_block_h2 page_info_header_tabs">
            <ul class="ui_tabs clear_fix page_info_tabs" data-inited="1">
                <li class="ui_tab_default">
                    <div class="ui_tab_plain" onclick="return false;" role="link">
                        Информация
                    </div>
                </li>
                <div class="ui_tabs_slider _ui_tabs_slider"></div>
            </ul>
        </h2>
        <div id="page_info_wrap" class="page_info_wrap info info_redesign">
            <div class="community_info_block info">
                <div class="community_info_rows community_info_rows_redesign">
                    <div class="community_info_row info" title="Описание">
                        <div class="line_value">
                            <div class="page_description">Хабр основан в 2006 году. Издателем проекта является компания «TechMedia».<br><br>Аудитория проекта — прогрессивно мыслящие люди, интересующиеся будущим IT-рынка в целом и интернет-экономики в частности.<br>
                                <a class="wall_post_more" onclick="$('#more_info_block').slideToggle('fast'); $(this).remove(); return false;" style="cursor: pointer;">
                                    Показать полностью…
                                </a>
                                <span id="more_info_block" style="display: none"> Хабр будет одинаково интересен программистам и журналистам, рекламщикам и верстальщикам, аналитикам и копирайтерам, менеджерам высшего и среднего звена, владельцам крупных компаний и небольших фирм, а также всем тем, для кого IT — это не просто две буквы алфавита.</span>
                            </div>
                        </div>
                    </div>
                    <div class="community_info_row site" title="Веб-сайт">
                        <div class="line_value">
                            <a href="/away?to=habr" target="_blank" rel="noopener" data-options="{}">http://habr.com</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php for ($i = 1; $i <= 20; $i++): ?>
<div class="page_block">
    <div class="page_info_wrap info info_redesign">
        text text text
    </div>
</div>
<?php endfor; ?>

<?php /*echo \zikwall\easyonline\modules\post\widgets\Form::widget(['contentContainer' => $community]); */?>
<?php

$emptyMessage = '';
if ($canCreatePosts) {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>This community is still empty!</b><br>Start by posting something here...');
} elseif ($isMember) {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>This community is still empty!</b>');
} else {
    $emptyMessage = Yii::t('CommunityModule.views_community_index', '<b>You are not member of this community and there is no public content, yet!</b>');
}

/*echo zikwall\easyonline\modules\stream\widgets\StreamViewer::widget([
    'contentContainer' => $community,
    'streamAction' => '/community/community/stream',
    'messageStreamEmpty' => $emptyMessage,
    'messageStreamEmptyCss' => ($canCreatePosts) ? 'placeholder-empty-stream' : '',
]);*/
?>
