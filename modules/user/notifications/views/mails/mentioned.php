<?php
/* @var $this yii\web\View */
/* @var $viewable zikwall\easyonline\modules\user\notifications\Mentioned */
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
        <td>
            <?=
            \zikwall\easyonline\modules\core\widgets\mails\MailContentEntry::widget([
                'originator' => $originator,
                'content' => $viewable->source,
                'date' => $date,
                'space' => $space
            ])
            ?>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>
            <?=
            \zikwall\easyonline\modules\core\widgets\mails\MailButtonList::widget(['buttons' =>
                [
                    \zikwall\easyonline\modules\core\widgets\mails\MailButton::widget(['url' => $url, 'text' => Yii::t('UserModule.notifications_mails', 'View Online')
                    ])
            ]]);
            ?>
        </td>
    </tr>
</table>
<?php
$this->endContent();
