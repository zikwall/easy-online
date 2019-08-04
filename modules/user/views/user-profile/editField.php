<?php

use zikwall\easyonline\modules\core\libs\Html;
use yii\helpers\Url;
?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::backButton(['index'], ['label' => Yii::t('AdminModule.base', 'Back to overview'), 'class' => 'pull-right']); ?>
        </div>
    </div>

    <div class="page_block_header_inner _header_inner">
        <?php if (!$field->isNewRecord) : ?>
            <?= Yii::t('AdminModule.views_userprofile_editField', 'Edit profile field'); ?>
        <?php else: ?>
            <?= Yii::t('AdminModule.views_userprofile_editField', 'Create new profile field'); ?>
        <?php endif; ?>
    </div>
</div>

<div class="page_info_wrap">
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <?= $hForm->render($form); ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>

<script>

    /**
     * Switcher for Sub Forms (FormField Type)
     */

    // Hide all Subforms for types
    $(".fieldTypeSettings").hide();

    showTypeSettings = $("#profilefield-field_type_class").val();
    showTypeSettings = showTypeSettings.replace(/[\\]/g, '_');

    // Display only the current selected type form
    $("." + showTypeSettings).show();

    $("#profilefield-field_type_class").on('change', function () {
        // Hide all Subforms for types
        $(".fieldTypeSettings").hide();

        // Show Current Selected
        showTypeSettings = $("#profilefield-field_type_class").val();
        showTypeSettings = showTypeSettings.replace(/[\\]/g, '_');

        $("." + showTypeSettings).show();
    });

</script>
