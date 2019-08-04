<?php

use yii\helpers\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\PrerequisitesList;
?>
<p><?= Yii::t('AdminModule.views_setting_selftest', 'Checking encore software prerequisites.'); ?></p>

<?= PrerequisitesList::widget(); ?>
<br>

<?= Html::a(Yii::t('AdminModule.views_setting_selftest', 'Re-Run tests'), Url::to(['prerequisites']), ['class' => 'btn btn-primary']); ?>
