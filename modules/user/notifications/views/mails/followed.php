<?php
/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2017 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */
/* @var $this yii\web\View */
/* @var $viewable zikwall\easyonline\modules\user\notifications\Followed */
/* @var $url string */
/* @var $date string */
/* @var $isNew boolean */
/* @var $isNew boolean */
/* @var $originator \zikwall\easyonline\modules\user\models\User */
/* @var source yii\db\ActiveRecord */
/* @var contentContainer \zikwall\easyonline\modules\content\components\ContentContainerActiveRecord */
/* @var space zikwall\easyonline\modules\space\models\Space */
/* @var record \zikwall\easyonline\modules\notification\models\Notification */
/* @var html string */
/* @var text string */
?>

<?php $this->beginContent('@notification/views/layouts/mail.php', $_params_); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
    <tr>
        <td style="font-size: 14px; line-height: 22px; font-family:Open Sans,Arial,Tahoma, Helvetica, sans-serif; color:<?= Yii::$app->view->theme->variable('text-color-highlight', '#555555') ?>; font-weight:300; text-align:left;">
            <?= $viewable->html(); ?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #eee;padding-top:10px;">
            <?= \zikwall\easyonline\modules\core\widgets\mails\MailContentContainerInfoBox::widget(['container' => $originator])?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>
            <?=
            \zikwall\easyonline\modules\core\widgets\mails\MailButtonList::widget(['buttons' => [
                    \zikwall\easyonline\modules\core\widgets\mails\MailButton::widget(['url' => $url, 'text' => Yii::t('UserModule.notifications_mails', 'View Online')])
            ]]);
            ?>
        </td>
    </tr>
</table>
<?php
$this->endContent();
