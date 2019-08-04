<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use zikwall\easyonline\modules\core\helpers\TimezoneHelper;

/**
 * @var $model \zikwall\easyonline\modules\admin\models\forms\BasicSettingsForm
 */
?>

<div class="panel-body">
    <h4><?= Yii::t('AdminModule.setting', 'General Settings'); ?></h4>
    <div class="help-block">
        <?= Yii::t('AdminModule.setting', 'Here you can configure basic settings of your social network.'); ?>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name'); ?>

    <?= $form->field($model, 'baseUrl'); ?>
    <p class="help-block"><?= Yii::t('AdminModule.views_setting_index', 'E.g. http://example.com/'); ?></p>

    <?php $allowedLanguages = Yii::$app->i18n->getAllowedLanguages(); ?>
    <?php if (count($allowedLanguages) > 1) : ?>
        <?= $languageDropDown = $form->field($model, 'defaultLanguage')->dropDownList($allowedLanguages, ['data-ui-select2' => '']); ?>
    <?php endif; ?>

    <?= $form->field($model, 'timeZone')->dropDownList(TimezoneHelper::generateList()); ?>
    <h4><?= Yii::t('AdminModule.views_setting_index', 'Friendship'); ?></h4>
    <?= $form->field($model, 'enableFriendshipModule')->checkbox(); ?>
    <hr>

    <?= Html::submitButton(Yii::t('AdminModule.views_setting_index', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => ""]); ?>

    <?php ActiveForm::end(); ?>
</div>
