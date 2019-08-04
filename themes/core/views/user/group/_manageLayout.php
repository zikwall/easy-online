<?php

use zikwall\easyonline\modules\core\libs\Html;

?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview')]); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?php if (!$group->isNewRecord) : ?>
            <?= Yii::t('AdminModule.user', 'Manage group: {groupName}', ['groupName' => $group->name]); ?>
        <?php else: ?>
            <?= Yii::t('AdminModule.user', 'Add new group'); ?>
        <?php endif; ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_groups_index', 'Users can be assigned to different groups (e.g. teams, departments etc.) with specific standard spaces, community managers and permissions.'); ?>
</div>

<div class="page_info_wrap">
    <?= \zikwall\easyonline\modules\user\widgets\GroupManagerMenu::widget(['group' => $group]); ?>
    <br>
    <?php if (!$group->isNewRecord) : ?>
        <?php if ($group->is_admin_group) : ?>
            <div class="pull-right">
                 <span class="label label-danger">
                    <?= Yii::t('AdminModule.group', 'Administrative group'); ?>
                 </span>&nbsp
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="page_info_wrap">
        <?= $content; ?>
    </div>

</div>



