<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $user \zikwall\easyonline\modules\user\models\User
 * @var $module \zikwall\easyonline\modules\core\components\Module
 */

$img = Yii::getAlias('@web') . '/resources/img';
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
    <?/*= \app\widgets\ExampleTabs::widget(); */?>
    <div id="module-catalog-rows" class="module-catalog-rows module-catalog-rows_catalog module-catalog-with-suggest">
        <?php foreach ($availableModules as $moduleId => $module): ?>
            <div class="module-catalog-row clear_fix ">
                <a href="/app6637537">
                    <div class="module-catalog-row-img">
                        <img class="module-catalog-row-img-img" src="<?= $module->getContentContainerImage($user); ?>">
                    </div>
                </a>

                <div class="module-catalog-row_add">
                    <?php if ($user->canDisableModule($module->id)): ?>
                        <a class="flat_button" href="<?= Url::to(['/user/account/disable-module', 'moduleId' => $module->id]) ?>"
                           style="<?= $user->isModuleEnabled($module->id) ? '' : 'display:none' ?>"
                           data-action-click="content.container.disableModule"
                           data-action-url="<?= Url::to(['/user/account/disable-module', 'moduleId' => $module->id]) ?>" data-reload="1"
                           data-action-confirm="<?= Yii::t('UserModule.views_account_editModules', 'Are you really sure? *ALL* module data for your profile will be deleted!') ?>">
                            <?= Yii::t('UserModule.views_account_editModules', 'Disable') ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($module->getContentContainerConfigUrl($user) && $user->isModuleEnabled($module->id)) : ?>
                        <?= Html::a(Yii::t('UserModule.views_account_editModules', 'Configure'), $module->getContentContainerConfigUrl($user), ['class' => 'btn btn-sm btn-default']); ?>
                    <?php endif; ?>

                    <a href="<?= Url::to(['/user/account/enable-module', 'moduleId' => $module->id]) ?>" style="<?= $user->isModuleEnabled($module->id) ? 'display:none' : '' ?>"
                       data-action-click="content.container.enableModule" data-action-url="<?= Url::to(['/user/account/enable-module', 'moduleId' => $module->id]) ?>" data-reload="1"
                       class="btn btn-sm btn-primary enable" data-ui-loader>
                        <?= Yii::t('UserModule.views_account_editModules', 'Enable') ?>
                    </a>
                </div>

                <div class="module-catalog-row-info">
                    <div class="module-catalog-row-field module-catalog-row-name">
                        <a href="/app6637537" class="module-catalog-row-name-link">
                            <?= $module->getContentContainerName($user); ?>
                        </a>
                        <!--<div class="encore_module_catalog_label_new">Новое</div>-->
                    </div>
                    <div class="module-catalog-row-field module-catalog-row-desc">
                        <?= $module->getContentContainerDescription($user); ?>
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
