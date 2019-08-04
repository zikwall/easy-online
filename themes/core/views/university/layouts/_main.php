<?php
/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 */

$this->setPageTitle('Внутренний университет');
?>

<?php $this->beginContent('@easyonline/modules/university/views/layouts/_layout.php') ?>

    <div class="page_block">
        <div class="page_block_header clear_fix">
            <div class="page_block_header_inner _header_inner">
                <?= Yii::t('UniversityModule.base','<strong>University</strong>');?>
            </div>
        </div>

        <?= zikwall\easyonline\modules\university\widgets\UniversityTabs::widget(); ?>

        <div class="page_info_wrap">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>
