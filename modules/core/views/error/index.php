<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->pageTitle = Yii::t('base', 'Error');
?>

<section class="corporate-heading section">
    <div class="section__inner">
        <h2 class="text-huge text-mediumblue text-thicker space-bottom--large corporate-heading__title" data-blurb="<?= Html::encode($message); ?>">
            <?= Yii::t('base', "Oooops..."); ?> <?= Yii::t('base', "It looks like you may have taken the wrong turn."); ?>
        </h2>
        <p class="text-black text-medium space-top--large space-bottom--large corporate-heading__subtext">
            <?= Html::encode($message); ?>
        </p>
    </div>
    <a href="<?= Url::home() ?>" class="btn btn-primary"><?= Yii::t('base', 'Back to dashboard'); ?></a>
</section>