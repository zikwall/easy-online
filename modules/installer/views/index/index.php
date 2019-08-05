<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="panel panel-default animated fadeIn">

    <div class="panel-body text-center">
        <br>
        <br>
        <p class="lead"><?php echo Yii::t('InstallerModule.views_index_index', '<strong>Welcome</strong> to EasyOnline<br>Your Social Network Toolbox'); ?></p>
        <p><?php echo Yii::t('InstallerModule.views_index_index', 'This wizard will install and configure your own EasyOnline instance.<br><br>To continue, click Next.'); ?></p>
        <br>
        <hr>
        <br>
        <?php echo Html::a(Yii::t('InstallerModule.views_index_index', "Next") . ' <i class="fa fa-arrow-circle-right"></i>', Url::to(['go']), ['class' => 'btn btn-lg btn-primary', 'data-ui-loader' => '']); ?>
        <br>
        <br>
    </div>


</div>

<?= \zikwall\easyonline\modules\core\widgets\LanguageChooser::widget(); ?>
