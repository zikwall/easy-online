<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $model \zikwall\easyonline\modules\admin\models\forms\DesignSettingsForm
 * @var $themes \zikwall\easyonline\modules\core\components\Theme[]
 */

?>
<div class="page_block_header clear_fix">

    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.setting', 'Appearance Settings'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.setting', 'These settings refer to the appearance of your social network.'); ?>
</div>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="page_info_wrap">

    <?= $form->field($model, 'theme')->dropDownList($themes); ?>

    <?= $form->field($model, 'backendTheme')->dropDownList($themes); ?>

    <?= $form->field($model, 'paginationSize'); ?>

    <?= $form->field($model, 'displayName')->dropDownList(['{username}' => Yii::t('AdminModule.views_setting_design', 'Username (e.g. john)'), '{profile.firstname} {profile.lastname}' => Yii::t('AdminModule.views_setting_design', 'Firstname Lastname (e.g. John Doe)')]); ?>

    <?= $form->field($model, 'dateInputDisplayFormat')->dropDownList([
        '' => Yii::t('AdminModule.views_setting_design', 'Auto format based on user language - Example: {example}', ['{example}' => Yii::$app->formatter->asDate(time(), 'short')]),
        'php:d/m/Y' => Yii::t('AdminModule.views_setting_design', 'Fixed format (mm/dd/yyyy) - Example: {example}', ['{example}' => Yii::$app->formatter->asDate(time(), 'php:d/m/Y')]),
    ]);
    ?>

</div>

<div class="block_footer">
    <?= Html::submitButton(Yii::t('AdminModule.views_setting_index', 'Save'), ['class' => 'flat_button button_wide', 'data-ui-loader' => ""]); ?>
</div>

<?php ActiveForm::end(); ?>
