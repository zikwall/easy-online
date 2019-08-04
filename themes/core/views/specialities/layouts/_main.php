<?php
/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 */

$this->setPageTitle('Направления обучения');

?>

<?php $this->beginContent('@easyonline/modules/university/views/layouts/_layout.php') ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('AdminModule.user', '<strong>Information</strong>'); ?>
    </div>
    <div class="panel-body">
        <?= $content; ?>
    </div>
</div>
<?php $this->endContent(); ?>
