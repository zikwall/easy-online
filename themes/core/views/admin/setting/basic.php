<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use zikwall\easyonline\modules\core\helpers\TimezoneHelper;

/**
 * @var $model \zikwall\easyonline\modules\admin\models\forms\BasicSettingsForm
 */
?>
<div class="page_block_header clear_fix">
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.setting', 'General Settings'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.setting', 'Here you can configure basic settings of your social network.'); ?>
</div>

<?php $form = ActiveForm::begin(); ?>

<div class="page_info_wrap">
    <?= $form->field($model, 'name'); ?>

    <?= $form->field($model, 'baseUrl'); ?>
    <p class="help-block"><?= Yii::t('AdminModule.views_setting_index', 'E.g. http://example.com/'); ?></p>

    <?php $allowedLanguages = Yii::$app->i18n->getAllowedLanguages(); ?>
    <?php if (count($allowedLanguages) > 1) : ?>
        <?= $languageDropDown = $form->field($model, 'defaultLanguage')->dropDownList($allowedLanguages, ['data-ui-select2' => '']); ?>
    <?php endif; ?>

    <?= $form->field($model, 'timeZone')->dropDownList(TimezoneHelper::generateList()); ?>

</div>

    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('AdminModule.views_setting_index', 'Friendship'); ?>
        </div>
    </div>

    <div class="page_info_wrap">
        <?= $form->field($model, 'enableFriendshipModule')->checkbox(); ?>
    </div>

    <div class="block_footer">
        <?= Html::submitButton(Yii::t('AdminModule.views_setting_index', 'Save'), ['class' => 'flat_button button_wide', 'data-ui-loader' => ""]); ?>
    </div>

<?php ActiveForm::end(); ?>
