<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\bootstrap\Modal;
use \yii\widgets\Pjax;

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

    <?= \zikwall\easyonline\modules\admin\widgets\AdminModuleTabsWidget::widget(); ?>

    <div id="module-catalog-rows" class="module-catalog-rows module-catalog-rows_catalog module-catalog-with-suggest">
        <?php if (count($installedModules) == 0): ?>
            <br>
            <div><?= 'No modules installed yet. Install some to enhance the functionality!'; ?></div>
        <?php endif; ?>

        <?php foreach ($installedModules as $moduleId => $module) : ?>
            <div class="module-catalog-row clear_fix ">
                <a href="/app6637537">
                    <div class="module-catalog-row-img">
                        <img class="module-catalog-row-img-img" src="<?= $module->getImage(); ?>">
                    </div>
                </a>

                <div class="module-catalog-row_add">

                </div>

                <div class="module-catalog-row-info">
                    <div class="module-catalog-row-field module-catalog-row-name">
                        <a href="/app6637537" class="module-catalog-row-name-link">
                            <?= $module->getName(); ?>
                        </a>
                        <?php if (Yii::$app->hasModule($module->id)) : ?>
                            <span class="label light-blue"><div class="module-catalog-label-widget">Activated</div></span>
                        <?php endif; ?>
                    </div>
                    <div class="module-catalog-row-field module-catalog-row-desc">
                        <?= $module->getDescription(); ?>
                    </div>
                    <div class="module-catalog-row-field module-catalog-row-count">
                        <?= 'Version:'; ?> <?= $module->getVersion(); ?>
                        <?php if (Yii::$app->hasModule($module->id)) : ?>
                            <?php if ($module->getConfigUrl() != "") : ?>
                                &middot; <?= Html::a('Configure', $module->getConfigUrl(), ['style' => 'font-weight:bold']); ?>
                            <?php endif; ?>

                            &middot; <?= Html::a('Disable', Url::to(['module/disable', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'data-confirm' => 'Are you sure? *ALL* module data will be lost!']); ?>

                        <?php else: ?>
                            &middot; <?= Html::a('Enable', Url::to(['module/enable', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'style' => 'font-weight:bold', 'data-loader' => "modal", 'data-message' => 'Enable module...']); ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->moduleManager->canRemoveModule($moduleId)): ?>
                            &middot; <?= Html::a('Uninstall', Url::to(['module/remove', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'data-confirm' => 'Are you sure? *ALL* module related data and files will be lost!']); ?>
                        <?php endif; ?>

                        &middot; <?= Html::a('More info', Url::to(['module/info', 'moduleId' => $moduleId]), ['data-target' => '#globalModal', 'data-toggle'=>'modal',]); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="module-catalog-suggest-app" role="button">
        Не нашли нужное приложение? Вы можете <a href="/app5619682_-59800369#278817">предложить идею</a>.
    </div>
</div>


