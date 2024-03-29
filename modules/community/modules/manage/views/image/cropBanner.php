<?php

use zikwall\easyonline\compat\CActiveForm;

?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <?php $form = CActiveForm::begin(['id' => 'community-crop-image-form']); ?>
        <?= $form->errorSummary($model); ?>
        <?= $form->hiddenField($model, 'cropX', ['id' => 'cropX']); ?>
        <?= $form->hiddenField($model, 'cropY', ['id' => 'cropY']); ?>
        <?= $form->hiddenField($model, 'cropW', ['id' => 'cropW']); ?>
        <?= $form->hiddenField($model, 'cropH', ['id' => 'cropH']); ?>

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t('UserModule.views_profile_cropBannerImage', '<strong>Modify</strong> your title image'); ?></h4>
        </div>
        <div class="modal-body">
            <style>
                /* Dirty Workaround against bootstrap and jcrop */
                img {
                    max-width: none;
                }

                .jcrop-keymgr {
                    display: none !important;
                }

            </style>

            <div id="cropimage">
                <?php
                echo \yii\helpers\Html::img($profileImage->getUrl('_org'), ['id' => 'foobar']);

                echo raoul2000\jcrop\JCropWidget::widget([
                    'selector' => '#foobar',
                    'pluginOptions' => [
                        'aspectRatio' => 6.3,
                        'minSize' => [50, 50],
                        'setSelect' => [0, 0, 267, 48],
                        'bgColor' => 'black',
                        'bgOpacity' => '0.5',
                        'boxWidth' => '440',
                        'onChange' => new yii\web\JsExpression('function(c){ $("#cropX").val(c.x);$("#cropY").val(c.y);$("#cropW").val(c.w);$("#cropH").val(c.h); }')
                    ]
                ]);
                ?>
            </div>


        </div>
        <div class="modal-footer">

            <?php
            echo \zikwall\easyonline\widgets\AjaxButton::widget([
                'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
                    'url' => $community->createUrl('/community/manage/image/crop-banner'),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
            ?>

            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?= Yii::t('UserModule.views_profile_cropBannerImage', 'Close'); ?></button>


            <?= \zikwall\easyonline\widgets\LoaderWidget::widget(['id' => 'crop-loader', 'cssClass' => 'loader-modal hidden']); ?>
        </div>

        <?= \zikwall\easyonline\widgets\DataSaved::widget(); ?>
        <?php CActiveForm::end(); ?>

    </div>

</div>


