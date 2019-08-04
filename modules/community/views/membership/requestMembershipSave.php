<div class="modal-dialog animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t('CommunityModule.views_community_requestMembershipSave', "<strong>Request</strong> community membership"); ?></h4>
        </div>
        <div class="modal-body">

            <div class="text-center">
                <?= Yii::t('CommunityModule.views_community_requestMembershipSave', 'Your request was successfully submitted to the community administrators.'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <hr/>
            <button type="button" class="btn btn-primary"
                    data-dismiss="modal"><?= Yii::t('CommunityModule.views_community_requestMembershipSave', 'Close'); ?></button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#requestMembershipButton').replaceWith('<?= \zikwall\easyonline\modules\community\widgets\MembershipButton::widget(['community' => $community]) ?>');
</script>
