<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="initial-scale=1.0"/>
        <meta name="format-detection" content="telephone=no"/>

        <title><?= Html::encode(Yii::$app->name); ?></title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,100,400,600' rel='stylesheet' type='text/css'>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <
    <table align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td >
               <span >
                   <a href="<?= Url::to(['/'], true); ?>">
                        <?= Html::encode(Yii::$app->name); ?>
                   </a>
               </span>
            </td>
        </tr>
    </table>

    <?= $content ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>