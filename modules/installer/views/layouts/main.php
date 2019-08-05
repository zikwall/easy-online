<?php

use yii\helpers\Html;
use zikwall\easyonline\themes\core\bundles\EncoreBundle;

/* @var $this \yii\web\View */
/* @var $content string */

EncoreBundle::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo Html::encode($this->title); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="language" content="en"/>

        <?= Html::csrfMetaTags() ?>

        <?php $this->head() ?>

        <!-- start: render additional head (css and js files) -->
        <?php echo $this->render('@easyonline/modules/core/views/layouts/head'); ?>
        <!-- end: render additional head -->
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="container installer" style="margin: 0 auto; max-width: 770px;">
        <?php echo $content; ?>
    </div>

    <div class="clear"></div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
