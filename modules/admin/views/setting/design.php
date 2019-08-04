<?php

use yii\widgets\ActiveForm;

/**
 * @var $model \zikwall\easyonline\modules\admin\models\forms\DesignSettingsForm
 * @var $themes \zikwall\easyonline\modules\core\components\Theme[]
 */

?>

    <h4><?= Yii::t('AdminModule.setting', 'Appearance Settings'); ?></h4>
    <div class="help-block">
        <?= Yii::t('AdminModule.setting', 'These settings refer to the appearance of your social network.'); ?>
    </div>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'theme')->dropDownList($themes); ?>

    <?= $form->field($model, 'backendTheme')->dropDownList($themes); ?>

    <?= $form->field($model, 'paginationSize'); ?>

    <?= $form->field($model, 'displayName')->dropDownList(['{username}' => Yii::t('AdminModule.views_setting_design', 'Username (e.g. john)'), '{profile.firstname} {profile.lastname}' => Yii::t('AdminModule.views_setting_design', 'Firstname Lastname (e.g. John Doe)')]); ?>

    <?= $form->field($model, 'dateInputDisplayFormat')->dropDownList([
        '' => Yii::t('AdminModule.views_setting_design', 'Auto format based on user language - Example: {example}', ['{example}' => Yii::$app->formatter->asDate(time(), 'short')]),
        'php:d/m/Y' => Yii::t('AdminModule.views_setting_design', 'Fixed format (mm/dd/yyyy) - Example: {example}', ['{example}' => Yii::$app->formatter->asDate(time(), 'php:d/m/Y')]),
    ]);
    ?>

    <hr>
    <?= \yii\helpers\Html::submitButton(Yii::t('AdminModule.views_setting_design', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => ""]); ?>

    <?php ActiveForm::end(); ?>
