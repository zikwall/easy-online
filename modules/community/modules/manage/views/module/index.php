<?php

use yii\helpers\Html;
?><div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('CommunityModule.views_admin_modules', '<strong>Community</strong> Modules'); ?>
    </div>
    <div class="panel-body">

        <?php if (count($availableModules) == 0): ?>
            <p><?= Yii::t('CommunityModule.views_admin_modules', 'Currently there are no modules available for this community!'); ?></p>
        <?php else: ?>
            <?= Yii::t('CommunityModule.views_admin_modules', 'Enhance this community with modules.'); ?><br>
        <?php endif; ?>


        <?php foreach ($availableModules as $moduleId => $module): ?>
            <hr>
            <div class="media">
                <img class="media-object img-rounded pull-left" data-src="holder.js/64x64" alt="64x64"
                     style="width: 64px; height: 64px;"
                     src="<?= $module->getContentContainerImage($community); ?>">

                <div class="media-body">
                    <h4 class="media-heading"><?= $module->getContentContainerName($community); ?>
                        <?php if ($community->isModuleEnabled($moduleId)) : ?>
                            <small><span class="label label-success"><?= Yii::t('CommunityModule.views_admin_modules', 'Activated'); ?></span></small>
                        <?php endif; ?>
                    </h4>

                    <p><?= $module->getContentContainerDescription($community); ?></p>

                    <?php if ($community->canDisableModule($moduleId)): ?>
                        <a href="#" style="<?= $community->isModuleEnabled($moduleId) ? '' : 'display:none' ?>"
                           data-action-click="content.container.disableModule" 
                           data-action-url="<?= $community->createUrl('/community/manage/module/disable', ['moduleId' => $moduleId]) ?>" data-reload="1"
                           data-action-confirm="<?= Yii::t('CommunityModule.views_admin_modules', 'Are you sure? *ALL* module data for this community will be deleted!') ?>"
                           class="btn btn-sm btn-primary disable disable-module-<?= $moduleId ?>" data-ui-loader>
                               <?= Yii::t('CommunityModule.views_admin_modules', 'Disable') ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($module->getContentContainerConfigUrl($community) && $community->isModuleEnabled($moduleId)) : ?>
                        <a href="<?= $module->getContentContainerConfigUrl($community) ?>" class="btn btn-sm btn-default configure-module-<?= $moduleId ?>">
                            <?= Yii::t('CommunityModule.views_admin_modules', 'Configure') ?>
                        </a>
                    <?php endif; ?>
                    
                    <a href="#"  style="<?= $community->isModuleEnabled($moduleId) ? 'display:none' : '' ?>"
                       data-action-click="content.container.enableModule" data-action-url="<?= $community->createUrl('/community/manage/module/enable', ['moduleId' => $moduleId]) ?>" data-reload="1"
                       class="btn btn-sm btn-primary enable enable-module-<?= $moduleId ?>" data-ui-loader>
                        <?= Yii::t('CommunityModule.views_admin_modules', 'Enable') ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>