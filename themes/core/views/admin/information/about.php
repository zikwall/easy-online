<?php

use yii\helpers\Html;
?>

<div class="page_info_wrap">
    <?php if ($isNewVersionAvailable) : ?>
        <div class="alert alert-danger">
            <p>
                <strong><?= Yii::t('AdminModule.views_about_index', 'There is a new update available! (Latest version: %version%)', ['%version%' => $latestVersion]); ?></strong><br>
                <?= Html::a("https://www.encore.com", "https://www.github.com/zikwall/encore"); ?>
            </p>
        </div>
    <?php elseif ($isUpToDate): ?>
        <div class="alert alert-info">
            <p>
                <strong><?= Yii::t('AdminModule.views_about_index', 'This enCore installation is up to date!'); ?></strong><br />
                <?= Html::a("https://www.encore.com", "https://www.github.com/zikwall/encore"); ?>
            </p>
        </div>
    <?php endif; ?>

    <p>
        <?= Yii::t('AdminModule.views_about_index', 'Currently installed version: %currentVersion%', ['%currentVersion%' => '<strong>' . Yii::$app->version . '</strong>']); ?><br>
    </p>
    <br>

    <?php if (YII_DEBUG) : ?>
        <p class="alert alert-danger">
            <strong><?= Yii::t('AdminModule.views_about_index', 'enCore is currently in debug mode. Disable it when running on production!'); ?></strong><br>
            <?= Yii::t('AdminModule.views_about_index', 'See installation manual for more details.'); ?>
        </p>
    <?php else: ?>
        <p class="alert alert-success">
            <strong><?= Yii::t('AdminModule.views_about_index', 'The site is in production mode. For further development, you can switch it to debug mode'); ?></strong><br>
            <?= Yii::t('AdminModule.views_about_index', 'See installation manual for more details.'); ?>
        </p>
    <?php endif; ?>

    <hr>
    <span class="pull-right">
    <?= Yii::powered(); ?>
</span>
    © <?= date("Y") ?> enCore system

</div>