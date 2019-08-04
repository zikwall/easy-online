<?php

use yii\bootstrap\ActiveForm;

?>

<?php $modal = \zikwall\easyonline\modules\core\widgets\ModalDialog::begin([
    'header' => Yii::t('CommunityModule.views_community_invite', '<strong>Invite</strong> members')
])?>


<?php
$modalAnimationClass = ($model->hasErrors()) ? 'shake' : 'fadeIn';

if ($canInviteExternal && $model->hasErrors('inviteExternal')) {
    $isInviteExternalTabActiveClass = 'active';
    $isInviteTabActiveClass = '';
} else {
    $isInviteExternalTabActiveClass = '';
    $isInviteTabActiveClass = 'active';
}
?>

<?php $form = ActiveForm::begin(['id' => 'community-invite-modal-form', 'action' => $submitAction]) ?>
    <div class="modal-body">
        <?php if ($canInviteExternal) : ?>
            <div class="text-center">
                <ul id="tabs" class="nav nav-tabs tabs-center" data-tabs="tabs">
                    <li class="<?= $isInviteTabActiveClass ?> tab-internal">
                        <a href="#internal" data-toggle="tab"><?= Yii::t('CommunityModule.views_community_invite', 'Pick users'); ?></a>
                    </li>
                    <li class="<?= $isInviteExternalTabActiveClass ?> tab-external">
                        <a href="#external" data-toggle="tab"><?= Yii::t('CommunityModule.views_community_invite', 'Invite by email'); ?></a>
                    </li>
                </ul>
            </div>
            <br/>
        <?php endif; ?>

        <div class="tab-content">
            <div class="tab-pane <?= $isInviteTabActiveClass ?>" id="internal">

                <?= Yii::t('CommunityModule.views_community_invite', 'To invite users to this community, please type their names below to find and pick them.'); ?>

                <br/><br/>
                <?= \zikwall\easyonline\modules\user\widgets\UserPickerField::widget([
                    'id' => 'community-invite-user-picker',
                    'form' => $form,
                    'model' => $model,
                    'attribute' => 'invite',
                    'url' => $searchUrl,
                    'disabledItems' => [Yii::$app->user->guid],
                    'focus' => true
                ])?>

            </div>

            <?php if ($canInviteExternal) : ?>
                <div class="<?= $isInviteExternalTabActiveClass ?> tab-pane" id="external">
                    <?= Yii::t('CommunityModule.views_community_invite', 'You can also invite external users, which are not registered now. Just add their e-mail addresses separated by comma.'); ?>
                    <br><br>
                    <?= $form->field($model, 'inviteExternal')->textarea(['id' => 'community-invite-external', 'rows' => '3', 'placeholder' => Yii::t('CommunityModule.views_community_invite', 'Email addresses')]); ?>
                </div>
            <?php endif; ?>
            <script>
            $('.tab-internal a').on('shown.bs.tab', function (e) {
                $('#community-invite-user-picker').data('picker').focus();
            });

            $('.tab-external a').on('shown.bs.tab', function (e) {
                $('#community-invite-external').focus();
            });
            </script>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" data-action-click="ui.modal.submit" data-action-submit class="btn btn-primary"  data-ui-loader><?= $submitText ?></a>
    </div>
<?php ActiveForm::end() ?>

<?php \zikwall\easyonline\modules\core\widgets\ModalDialog::end(); ?>
