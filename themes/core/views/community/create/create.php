<?php
use zikwall\easyonline\modules\core\widgets\ActiveForm;
use yii\helpers\Url;
use zikwall\easyonline\modules\community\widgets\CommunityNameColorInput;
use yii\helpers\Html;

/* @var $model \zikwall\easyonline\modules\community\models\Community */
/* @var $visibilityOptions array */
/* @var $joinPolicyOptions array */

$animation = $model->hasErrors() ? 'shake' : 'fadeIn';
?>

<?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
<div class="black_info_wrap">
    <?= CommunityNameColorInput::widget(['form' => $form, 'model' => $model]) ?>

    <?= $form->field($model, 'description')->textarea(['placeholder' => Yii::t('CommunityModule.views_create_create', 'community description'), 'rows' => '3']); ?>

    <a data-toggle="collapse" id="access-settings-link" href="#collapse-access-settings" style="font-size: 11px;">
        <i class="fa fa-caret-right"></i> <?php echo Yii::t('CommunityModule.views_create_create', 'Advanced access settings'); ?>
    </a>

    <div id="collapse-access-settings" class="panel-collapse collapse">
        <br/>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'visibility')->radioList($visibilityOptions)->hint(false); ?>
            </div>
            <div class="col-md-6 communityJoinPolicy">
                <?= $form->field($model, 'join_policy')->radioList($joinPolicyOptions)->hint(false); ?>
            </div>
        </div>
    </div>

    <div class="block_footer">
        <?= \zikwall\easyonline\modules\ui\widgets\ModalButton::submitModal(Url::to(['/community/create/create']), Yii::t('CommunityModule.views_create_create', 'Next')); ?>
        <?php /** ModalButton::submitModal(Url::to(['/community/create/create', 'skip' => 1]), Yii::t('CommunityModule.views_create_create', 'Skip'))
        ->setType('default')->icon('fa-forward', true)->cssClass('tt')->options(['title' => Yii::t('CommunityModule.views_create_create', 'Skip other steps')]) */?>
    </div>
</div>
<?php ActiveForm::end(); ?>


<script type="text/javascript">

    var $checkedVisibility = $('input[type=radio][name="Community[visibility]"]:checked');
    if ($checkedVisibility.length && $checkedVisibility[0].value == 0) {
        $('.communityJoinPolicy').hide();
    }

    $('input[type=radio][name="Community[visibility]"]').on('change', function() {
        if (this.value == 0) {
            $('.communityJoinPolicy').fadeOut();
        } else {
            $('.communityJoinPolicy').fadeIn();
        }
    });

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
