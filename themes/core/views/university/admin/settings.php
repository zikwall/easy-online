<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<div class="encore-help-block">
    Конфигурационная форма модуля университет
</div>

<hr>

<?php
$form = ActiveForm::begin([
    'id' => 'configure-form'
]);
?>
<?= $form->errorSummary($model); ?>

<div class="form-group">
    <?= $form->field($model, 'systemUniversity')
        ->dropDownList(\yii\helpers\ArrayHelper::map($universities, 'id', 'fullname'), ['class' => 'form-control', 'data-ui-select2' => '']);
    ?>
</div>

<div class="form-group">
    <?php
    $boolean = [
        3 => 'Markdown (стандартный)',
        1 => 'Quill',
        0 => 'Codemirror'
    ];
    echo $form->field($model, 'useWysiwyg')->label('Выбор редактора')->dropDownList($boolean, ['class' => 'form-control', 'data-ui-select2' => '']);
    ?>
</div>

<hr>

<div class="form-group">
    <?= $form->field($model, 'installingExampleDataset')->checkbox();
    ?>
</div>

<div class="form-group">
    <?= $form->field($model, 'useIssuesForSchedule', ['labelOptions' => ['class' => 'ans-label ng-binding']])->checkbox();?>
</div>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary'])?>
</div>
<?= \zikwall\easyonline\modules\core\widgets\DataSaved::widget(); ?>
<?php ActiveForm::end(); ?>


