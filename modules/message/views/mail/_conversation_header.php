<?php
use zikwall\easyonline\modules\core\libs\Html;
use zikwall\easyonline\modules\user\widgets\Image;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\Button;

/* @var $message \zikwall\easyonline\modules\message\models\Message */
?>

<?= Html::encode($message->title); ?>

<div class="pull-right">
    <?php if (count($message->users)) : ?>
        <?php if (count($message->users) != 1) : ?>
            <?= Button::primary( )
                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->sm()
                ->confirm( Yii::t('MessageModule.views_mail_show', '<strong>Confirm</strong> leaving conversation'),
                    Yii::t('MessageModule.views_mail_show', 'Do you really want to leave this conversation?'),
                    Yii::t('MessageModule.views_mail_show', 'Leave'))->tooltip(Yii::t('MessageModule.views_mail_show', 'Leave conversation'))?>
        <?php elseif (count($message->users) == 1) : ?>
            <?= Button::primary( )
                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->sm()
                ->confirm( Yii::t('MessageModule.views_mail_show', '<strong>Confirm</strong> deleting conversation'),
                    Yii::t('MessageModule.views_mail_show', 'Do you really want to delete this conversation?'),
                    Yii::t('MessageModule.views_mail_show', 'Delete'))->tooltip(Yii::t('MessageModule.views_mail_show', 'Delete conversation'))?>
            ?>
        <?php endif; ?>

        <?php foreach ($message->users as $user) : ?>
            <a href="<?= $user->getUrl(); ?>">
                <?= Image::widget(['user' => $user, 'width' => '25', 'showTooltip' => true])?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
