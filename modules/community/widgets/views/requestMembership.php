<div id="lightbox_requestWorkcommunity">

    <div class="panel panel_lightbox">
        <div class="content content_innershadow">

            <h2><?= Yii::t('CommunityModule.widgets_views_requestMembership', 'Request workcommunity membership'); ?></h2>

            <p>
                <?= Yii::t('CommunityModule.widgets_views_requestMembership', 'Please shortly introduce yourself, to become a approved member of this workcommunity.'); ?><br/>
            </p><br>

            <div class="form">

                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'workcommunity-apply-form',
                    'enableAjaxValidation' => true,
                ));
                ?>

                <div class="row_lightbox">
                    <?= $form->labelEx($model, 'message'); ?>
                    <?= $form->textArea($model, 'message', array('rows' => '5', 'class' => 'textinput w310')); ?>
                    <?= $form->error($model, 'message'); ?>
                </div>

                <div class="clearFloats"></div>

                <div class="row_lightbox buttons">
                    <?php //echo CHtml::submitButton('Send'); ?>

                    <?php
                    echo CHtml::ajaxButton(Yii::t('CommunityModule.widgets_views_requestMembership', 'Send'), array('workcommunity/requestMembershipForm', 'guid'=> $workcommunity->guid), array(
                        'type' => 'POST',
                        'beforeSend' => 'function(){
				jQuery("#loader_form_requestWorkcommunity").css("display", "block");
			}',
                        'success' => 'function(html){
				jQuery("#lightbox_requestWorkcommunity").replaceWith(html);
			}',
                    ), array('class' => 'input_button', 'id' => 'requestSubmit'.uniqid()));
                    ?>

                    <?= CHtml::link(Yii::t('CommunityModule.widgets_views_requestMembership', 'Cancel'), '#', array('onclick'=>'RequestWorkcommunitybox.close()', 'class' => 'button', 'style' => 'color: #fff;')); ?>
                    <div id="loader_form_requestWorkcommunity" class="loader_form"></div>
                    <div class="clearFloats"></div>
                </div>

                <?php $this->endWidget(); ?>

            </div><!-- form -->
        </div>
    </div>
</div>