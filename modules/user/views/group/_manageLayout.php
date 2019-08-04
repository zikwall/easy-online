<?php

use zikwall\easyonline\modules\core\libs\Html;

?>

<div class="panel-body">
    <div class="pull-right">
        <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview')]); ?>
    </div>

    <?php if (!$group->isNewRecord) : ?>
        <h4><?= Yii::t('AdminModule.user', 'Manage group: {groupName}', ['groupName' => $group->name]); ?></h4>
    <?php else: ?>
        <h4><?= Yii::t('AdminModule.user', 'Add new group'); ?></h4>
    <?php endif; ?>
</div>

<div class="card card-nav-tabs">
    <div class="card-header" data-background-color="purple">
        <div class="nav-tabs-navigation">
            <div class="nav-tabs-wrapper">
                <?= \zikwall\easyonline\modules\user\widgets\GroupManagerMenu::widget(['group' => $group]); ?>
            </div>
        </div>
    </div>
    <div class="card-content">
        <div class="tab-content">
            <?php if (!$group->isNewRecord) : ?>
                <?php if ($group->is_admin_group) : ?>
                    <div class="pull-right">
                        <span class="label label-danger">
                            <?= Yii::t('AdminModule.group', 'Administrative group'); ?>
                        </span>&nbsp;&nbsp;
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?= $content; ?>
        </div>
    </div>
</div>


