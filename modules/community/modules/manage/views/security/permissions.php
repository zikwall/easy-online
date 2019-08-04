<?php

use zikwall\easyonline\modules\user\widgets\PermissionGridEditor;
use zikwall\easyonline\modules\community\modules\manage\widgets\SecurityTabMenu;
?>

<div class="panel panel-default">
    <div>
        <div class="panel-heading">
            <?= Yii::t('CommunityModule.views_settings', '<strong>Security</strong> settings'); ?>
        </div>
    </div>

    <?= SecurityTabMenu::widget(['community' => $community]); ?>

    <div class="panel-body">
        <p class="help-block"><?= Yii::t('CommunityModule.views_settings', 'Permissions are assigned to different user-roles. To edit a permission, select the user-role you want to edit and change the drop-down value of the given permission.'); ?></p>
    </div>

    <ul id="tabs" class="nav nav-tabs tab-sub-menu">
        <?php foreach ($groups as $currentGroupId => $groupLabel): ?>
            <li class="<?= ($groupId === $currentGroupId) ? 'active' : '' ?>">
                <a href='<?= $community->createUrl('permissions', ['groupId' => $currentGroupId]) ?>'><?= $groupLabel ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="panel-body" style="padding-top:0px;">

        <?= PermissionGridEditor::widget(['permissionManager' => $community->permissionManager, 'groupId' => $groupId]); ?>
    </div>
</div>
