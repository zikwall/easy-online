<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\widgets\PermissionGridEditor;
?>

<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UserModule.account', '<strong>Security</strong> settings'); ?>
        </div>
    </div>
    <?php if ($multipleGroups) : ?>
        <h2 class="ui_block_h2 page_info_header_tabs">
            <div class="tab-menu">
                <ul class="nav nav-tabs">
                    <?php foreach ($groups as $groupId => $groupTitle) : ?>
                        <li>
                            <div class="ui_tab <?= $groupId == $group ? 'ui_tab_sel' : ''; ?>" role="link">
                                <?= Html::a(Html::encode($groupTitle), Url::to(['security', 'groupId' => $groupId])); ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="ui_tabs_slider _ui_tabs_slider" style="width: 92px; margin-left: 14px;"></div>
            </div>
        </h2>
    <?php endif; ?>
    <div class="page_info_wrap">
        <?= PermissionGridEditor::widget(['permissionManager' => $user->permissionManager, 'groupId' => $group]); ?>
    </div>
</div>
