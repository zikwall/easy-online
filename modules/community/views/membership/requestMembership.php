<?php

use zikwall\easyonline\compat\CActiveForm;
?>
<div class="modal-dialog animated fadeIn">
    <div class="modal-content">
        <?php $form = CActiveForm::begin(); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t('CommunityModule.views_community_requestMembership', "<strong>Request</strong> community membership"); ?></h4>
        </div>
        <div class="modal-body">

            <?= Yii::t('CommunityModule.views_community_requestMembership', 'Please shortly introduce yourself, to become an approved member of this community.'); ?>

            <br/>
            <br/>

            <?php //echo $form->labelEx($model, 'message');  ?>
            <?= $form->textArea($model, 'message', array('rows' => '8', 'class' => 'form-control', 'id' => 'request-message')); ?>
            <?= $form->error($model, 'message'); ?>

        </div>
        <div class="modal-footer">
            <hr/>
            <?php
            echo \zikwall\easyonline\widgets\AjaxButton::widget([
                'label' => Yii::t('CommunityModule.views_community_invite', 'Send'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                    'url' => $community->createUrl('/community/membership/request-membership-form'),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
            ?>
            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?= Yii::t('CommunityModule.views_community_requestMembership', 'Close'); ?></button>

            <?= \zikwall\easyonline\widgets\LoaderWidget::widget(['id' => 'send-loader', 'cssClass' => 'loader-modal hidden']); ?>

        </div>

        <?php CActiveForm::end(); ?>
    </div>

</div>


<script type="text/javascript">

    // set focus to input field
    $('#request-message').focus()

    // Shake modal after wrong validation
<?php if ($model->hasErrors()) { ?>
        $('.modal-dialog').removeClass('fadeIn');
        $('.modal-dialog').addClass('shake');
<?php } ?>

</script>
