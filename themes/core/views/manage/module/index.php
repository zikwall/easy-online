<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="page_block">
    <div class="module-catalog-header">
        <div class="module-catalog-header-desc from-page">
            <div class="module-catalog-header-desc_text">
                <?= Yii::t('UserModule.views_account_editModules', '<strong>User</strong> modules'); ?>
            </div>
            <div class="module-catalog-header-desc-link module-catalog-goto-arrow">
                <?= Yii::t('UserModule.views_account_editModules', 'Enhance your profile with modules.'); ?>
            </div>
        </div>
    </div>

    <div id="module-catalog-rows" class="module-catalog-rows module-catalog-rows_catalog module-catalog-with-suggest">
        <?php foreach ($availableModules as $moduleId => $module): ?>
            <div class="module-catalog-row clear_fix ">
                <a href="/app6637537">
                    <div class="module-catalog-row-img">
                        <img class="module-catalog-row-img-img" src="<?= $module->getContentContainerImage($community); ?>">
                    </div>
                </a>

                <div class="module-catalog-row_add">
                    <?php if ($community->canDisableModule($module->id)): ?>
                        <a class="flat_button" href="<?= Url::to(['/user/account/disable-module', 'moduleId' => $module->id]) ?>"
                           style="<?= $community->isModuleEnabled($module->id) ? '' : 'display:none' ?>"
                           data-action-click="content.container.disableModule"
                           data-action-url="<?= $community->createUrl('/community/manage/module/disable', ['moduleId' => $moduleId]) ?>" data-reload="1"
                           data-action-confirm="<?= Yii::t('CommunityModule.views_admin_modules', 'Are you sure? *ALL* module data for this community will be deleted!') ?>">
                            <?= Yii::t('CommunityModule.views_admin_modules', 'Disable') ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($module->getContentContainerConfigUrl($community) && $community->isModuleEnabled($module->id)) : ?>
                        <?= Html::a(Yii::t('UserModule.views_account_editModules', 'Configure'), $module->getContentContainerConfigUrl($community), ['class' => 'btn btn-sm btn-default']); ?>
                    <?php endif; ?>

                    <a href="<?= Url::to(['/community/manage/module/enable', 'moduleId' => $module->id]) ?>" style="<?= $community->isModuleEnabled($module->id) ? 'display:none' : '' ?>"
                       data-action-click="content.container.enableModule" data-action-url="<?= $community->createUrl('/community/manage/module/enable', ['moduleId' => $moduleId]) ?>" data-reload="1"
                       class="btn btn-sm btn-primary enable" data-ui-loader>
                        <?= Yii::t('CommunityModule.views_admin_modules', 'Enable') ?>
                    </a>
                </div>

                <div class="module-catalog-row-info">
                    <div class="module-catalog-row-field module-catalog-row-name">
                        <a href="/app6637537" class="module-catalog-row-name-link">
                            <?= $module->getContentContainerName($community); ?>
                        </a>
                        <!--<div class="encore_module_catalog_label_new">Новое</div>-->
                    </div>
                    <div class="module-catalog-row-field module-catalog-row-desc">
                        <?= $module->getContentContainerDescription($community); ?>
                    </div>
                    <div class="module-catalog-row-field module-catalog-row-count">
                        Установлено в 29<span class="num_delim"> </span>639 сообществах
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="module-catalog-suggest-app" role="button">
        Не нашли нужное приложение? Вы можете <a href="/app5619682_-59800369#278817">предложить идею</a>.
    </div>
</div>