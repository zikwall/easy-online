<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 27.04.2017
 * Time: 11:36
 */

$this->pageTitle = Yii::t('UserModule.views_auth_createAccount', 'Create Account');
?>
<div class="page_block">
    <div class="page_info_wrap">
        <!-- BEGIN LOGIN -->
        <div class="">
            <!-- BEGIN LOGIN FORM -->
            <?php $form = \yii\widgets\ActiveForm::begin(['enableClientValidation' => false]); ?>
            <div class="form-title">
                <span class="form-title">Регистрация учетной записи</span>
            </div>
            <?= $hForm->render($form); ?>
            <?php \yii\widgets\ActiveForm::end(); ?>
            <!-- END LOGIN FORM -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        // set cursor to login field
        $('#User_username').focus();
    })

    // Shake panel after wrong validation
    <?php foreach ($hForm->models as $model) : ?>
    <?php if ($model->hasErrors()) : ?>
    $('#create-account-form').removeClass('bounceIn');
    $('#create-account-form').addClass('shake');
    $('#app-title').removeClass('fadeIn');
    <?php endif; ?>
    <?php endforeach; ?>

</script>