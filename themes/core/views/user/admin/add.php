<?php
/**
 * @var $hForm \zikwall\easyonline\modules\user\models\forms\Registration
 */
use zikwall\easyonline\modules\core\libs\Html;
use yii\helpers\Url;
\zikwall\easyonline\modules\core\assets\subassets\TabbedFormAsset::register($this);
?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a(Yii::t('AdminModule.base', 'Back to overview'),
                Url::to(['index']), ['class' => 'flat_button button_wide secondary', 'data-ui-loader' => '']); ?>
        </div>
    </div>
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_user_edit', 'Edit user: {name}', ['name' => $user->displayName]); ?>
    </div>
</div>

<?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['data-ui-widget' => 'ui.form.TabbedForm', 'data-ui-init' => '']]); ?>
<?= $hForm->render($form, true, true); ?>
<?php \yii\bootstrap\ActiveForm::end(); ?>

