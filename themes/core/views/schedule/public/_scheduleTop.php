<?php
use yii\helpers\Html;
?>
<style>
    .schedule_cover_info {
        padding: 12px 15px;
        border-bottom: 1px solid #e7e8ec;
    }
    .schedule_cover_actions {
        float: right;
        padding: 8px 5px;
    }
    .schedule_cover_info .group_cta, .schedule_cover_info .group_send_msg, .schedule_cover_info .page_actions>.flat_button {
        float: left;
        margin-right: 10px;
    }
    .schedule_cover_info .page_actions_wide {
        float: left;
        height: 30px;
    }
    .schedule_cover_image {
        position: relative;
        float: left;
        height: 46px;
        width: 46px;
        margin-right: 7px;
    }
    .schedule_cover_info .post_img {
        height: 46px;
        width: 46px;
    }
    .schedule_cover_info .page_top {
        overflow: hidden;
        padding: 2px 11px 5px 5px;
        margin: 0 0 -5px;
    }
</style>

<div class="schedule_cover_info clear_fix">
    <div class="schedule_cover_actions">
        <div id="public_actions_wrap" class="group_actions_wrap group_actions_wrap_redesign">
            <aside aria-label="Действия">
                <div id="page_actions" class="page_actions" style="">
                    <div class="group_cta">
                        <a href="https://habr.com">
                            <button class="flat_button button_wide">Перейти</button>
                        </a>
                    </div>
                    <div class="page_actions_wide clear_fix no_actions redesign">
                        <div class="page_action_left fl_l">
                            <?= Html::a('<span class="page_actions_dd_label">Панель фильров</span>', '#', [
                                'class' => 'flat_button secondary page_actions_btn',
                                'onclick' => '$("#filter").slideToggle("fast");$("#filter").focus();return false;'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <?php if (Yii::$app->controller->action->id == 'global-alternative'): ?>
        <a class="schedule_cover_image" href="/photo-20629724_456249195">
            <img src="https://sun1-17.userapi.com/c847121/v847121550/8114a/_n9H1aYhSw8.jpg?ava=1" class="post_img">
        </a>

        <div class="page_top">
            <h2 class="page_name"><?= $group->displayName; ?>
                <a href="/verify" class="page_verified "></a>
            </h2>
            <div class="page_current_info" id="page_current_info">
                <span class="current_text">НЛО с вами!</span>
            </div>
        </div>
    <?php endif; ?>

    <?= $this->render('_informationHeader'); ?>

    <br><br>

    <?= \zikwall\easyonline\modules\schedule\widgets\ScheduleFilterWidget::widget([
            'days' => $days, 'couples' => $couples, 'weekly' => $weekly, 'disciplines' => $disciplines, 'teachers' => $teachers,
            'isContainer' => true,
            'group' => $userGroup
    ]); ?>

</div>
