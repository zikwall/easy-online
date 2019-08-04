<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $module \zikwall\easyonline\modules\core\components\Module;
 */
?>

<?= \zikwall\easyonline\modules\admin\widgets\ModuleTabs::widget(); ?>

<div class="panel panel-default">
    <div class="panel-body">

        <?php if (count($installedModules) == 0): ?>
            <br>
            <div><?= 'No modules installed yet. Install some to enhance the functionality!'; ?></div>
        <?php endif; ?>

        <?php foreach ($installedModules as $moduleId => $module) : ?>
            <div class="media">
                <img class="media-object img-rounded pull-left" data-src="holder.js/64x64" alt="64x64" style="width: 74px; height: 64px; margin-right: 10px;" src="<?= $module->getImage(); ?>">

                <div class="media-body">
                    <h4 class="media-heading"><?= $module->getName(); ?>
                        <small>
                            <?php if (Yii::$app->hasModule($module->id)) : ?>
                                <span class="label light-blue"><?= 'Activated'; ?></span>
                            <?php endif; ?>
                        </small>
                    </h4>

                    <div class="list-body">
                        <small class="text-muted text-ellipsis"><?= $module->getDescription(); ?></small>
                    </div>

                    <div class="module-controls">

                        <?= 'Version:'; ?> <?= $module->getVersion(); ?>

                        <?php if (Yii::$app->hasModule($module->id)) : ?>
                            <?php if ($module->getConfigUrl() != "") : ?>
                                &middot; <?= Html::a('Configure', $module->getConfigUrl(), ['style' => 'font-weight:bold']); ?>
                            <?php endif; ?>

                            &middot; <?= Html::a('Disable', Url::to(['module/disable', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'data-confirm' => 'Are you sure? *ALL* module data will be lost!']); ?>

                        <?php else: ?>
                            &middot; <?= Html::a('Enable', Url::to(['module/enable', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'style' => 'font-weight:bold', 'data-message' => 'Enable module...']); ?>
                        <?php endif; ?>

                        <?php if (Yii::$app->moduleManager->canRemoveModule($moduleId)): ?>
                            &middot; <?= Html::a('Uninstall', Url::to(['module/remove', 'moduleId' => $moduleId]), ['data-method' => 'POST', 'data-confirm' => 'Are you sure? *ALL* module related data and files will be lost!']); ?>
                        <?php endif; ?>

                        &middot; <?= Html::a('More info', Url::to(['module/info', 'moduleId' => $moduleId]), ['data-target' => '#globalModal',]); ?>
                    </div>
                </div>
            </div>
            <hr/>
        <?php endforeach; ?>
    </div>
</div>
