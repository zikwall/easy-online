<div id="lightbox_requestWorkcommunity">

    <div class="panel panel_lightbox">
        <div class="content content_innershadow">

            <h2><?= Yii::t('CommunityModule.widgets_views_requestMembershipSave', 'Request workcommunity membership'); ?></h2>

            <p>
                <?= Yii::t('CommunityModule.widgets_views_requestMembershipSave', 'Your request was successfully submitted to the workcommunity administrators.'); ?><br/>
            </p>
            <br/>
            <?= CHtml::link(Yii::t('CommunityModule.widgets_views_requestMembershipSave', 'Close'), '#', array('onclick'=>'redirect();//RequestWorkcommunitybox.close()', 'class' => 'button', 'style' => 'color: #fff;')); ?>
            <div class="clearFloats"></div>

        </div>
    </div>

</div>

<script type="text/javascript">

    jQuery('#close_button_requestWorkcommunity').remove();

    /**
     * Refresh the current page
     */
    function redirect() {
        window.location.href = "<?php Yii::app()->createUrl('workcommunity/publicShow', array('guid' => $workcommunity->guid)); ?>"  ;
    }

</script>   