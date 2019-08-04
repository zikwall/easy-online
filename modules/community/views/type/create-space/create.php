<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\models\Setting;
use humhub\modules\space\models\Space;
use humhub\modules\space\permissions\CreatePublicSpace;
use humhub\modules\space\permissions\CreatePrivateSpace;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">
                <?= Yii::t('CommunityModule.spacetype', '<strong>Create</strong> new %typeTitle%', ['%typeTitle%' => $this->context->getTypeTitle($model)]); ?>
            </h4>
        </div>
        <div class="modal-body">
            <hr>
            <br>
            <?= humhub\modules\space\widgets\SpaceNameColorInput::widget(['form' => $form, 'model' => $model]) ?>

            <?= $form->field($model, 'description')->textarea(['placeholder' => Yii::t('CommunityModule.views_create_create', 'Description'), 'rows' => '3']); ?>

            <a data-toggle="collapse" id="access-settings-link" href="#collapse-access-settings" style="font-size: 11px;">
                <i class="fa fa-caret-right"></i> <?= Yii::t('CommunityModule.views_create_create', 'Advanced access settings'); ?>
            </a>

            <div id="collapse-access-settings" class="panel-collapse collapse">
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'join_policy')->radioList($joinPolicyOptions); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'visibility')->radioList($visibilityOptions); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class=" modal-footer">
            <hr/>
            <br/>

            <a href="#" class="btn btn-primary" 
               data-action-click="ui.modal.submit" 
               data-ui-loader
               data-action-url="<?= Url::to(['/enterprise/spacetype/create-space/create', 'type_id' => $model->community_type_id]) ?>">
                   <?= Yii::t('CommunityModule.views_create_create', 'Next'); ?>
            </a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


<script type="text/javascript">
    $('#collapse-access-settings').on('show.bs.collapse', function () {
        // change link arrow
        $('#access-settings-link i').removeClass('fa-caret-right');
        $('#access-settings-link i').addClass('fa-caret-down');
    });

    $('#collapse-access-settings').on('hide.bs.collapse', function () {
        // change link arrow
        $('#access-settings-link i').removeClass('fa-caret-down');
        $('#access-settings-link i').addClass('fa-caret-right');
    });
</script>
