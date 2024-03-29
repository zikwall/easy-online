<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\admin\widgets\PrerequisitesList;
?>
<div class="panel panel-default animated fadeIn">

    <div class="panel-heading">
        <?php echo Yii::t('InstallerModule.views_setup_prerequisites', '<strong>System</strong> Check'); ?>
    </div>

    <div class="panel-body">
        <p><?php echo Yii::t('InstallerModule.views_setup_prerequisites', 'This overview shows all system requirements of EasyOnline.'); ?></p>

        <hr/>
        <?= PrerequisitesList::widget(); ?>
        
        <?php if (!$hasError): ?>
            <div class="alert alert-success">
                <?php echo Yii::t('InstallerModule.views_setup_prerequisites', 'Congratulations! Everything is ok and ready to start over!'); ?>
            </div>
        <?php endif; ?>

        <hr>

        <?php echo Html::a('<i class="fa fa-repeat"></i> ' . Yii::t('InstallerModule.views_setup_prerequisites', 'Check again'), ['/installer/setup/prerequisites'], ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>

        <?php if (!$hasError): ?>
            <?php echo Html::a(Yii::t('InstallerModule.views_setup_prerequisites', 'Next') . ' <i class="fa fa-arrow-circle-right"></i>', ['/installer/setup/database'], ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>
        <?php endif; ?>

    </div>
</div>