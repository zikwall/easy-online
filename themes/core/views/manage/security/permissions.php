<?php

use zikwall\easyonline\modules\user\widgets\PermissionGridEditor;
use zikwall\easyonline\modules\community\modules\manage\widgets\SecurityTabMenu;
use \zikwall\easyonline\modules\community\modules\manage\widgets\SecurityTabSubMenu;

?>

<div class="page_block">
    <?= SecurityTabMenu::widget(['community' => $community]); ?>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Security</strong> settings'); ?>
        </div>
    </div>

    <div class="encore-help-block">
        <?= Yii::t('CommunityModule.views_settings', 'Permissions are assigned to different user-roles. To edit a permission, select the user-role you want to edit and change the drop-down value of the given permission.'); ?>
    </div>

    <div class="page_info_wrap">
        <?= SecurityTabSubMenu::widget(['community' => $community, 'groups' => $groups, 'groupId' => $groupId]); ?>
        <?= PermissionGridEditor::widget(['permissionManager' => $community->permissionManager, 'groupId' => $groupId]); ?>
    </div>
</div>
