<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->pageTitle = Yii::t('base', 'Error');
?>

<div class="row">
    <div class="col-md-12 col-no-right-padding">
        <div class="page_block">
            <div class="page_block_header clear_fix">
                <div class="page_block_header_inner _header_inner">
                    <?= Yii::t('base', "Oooops..."); ?> <?= Yii::t('base', "It looks like you may have taken the wrong turn."); ?>
                </div>
            </div>

            <div class="page_info_wrap">
                <?= Html::encode($message); ?>
                <div class="separator"></div>
                <p>
                    <a href="<?= Url::home() ?>" class="btn btn-primary"><?= Yii::t('base', 'Back to dashboard'); ?></a>
                    <a onclick="window.history.back();" class="btn btn-default" data-ui-loader><?= Yii::t('base', 'To Back'); ?></a>
                </p>
            </div>
        </div>
    </div>
</div>

