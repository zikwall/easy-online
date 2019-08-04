<?php
/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 */

$this->setPageTitle('Расписание занятий');

?>

<?php $this->beginContent('@easyonline/modules/university/views/layouts/_layout.php') ?>

<?= $content; ?>

<?php $this->endContent(); ?>
