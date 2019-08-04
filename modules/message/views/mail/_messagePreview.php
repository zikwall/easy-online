<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\TimeAgo;
use zikwall\easyonline\modules\core\helpers\Helpers;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\widgets\Image;
use zikwall\easyonline\modules\ui\widgets\Label;


/* @var $userMessage \zikwall\easyonline\modules\message\models\UserMessage */
/* @var $active bool */

$message = $userMessage->message;
?>

<?php if ($message->getLastEntry() != null) : ?>
    <li data-message-preview="<?= $message->id ?>" class="messagePreviewEntry entry <?= $active ? 'selected' : ''?>">
        <a href="#" class="mail-link" data-action-click="mail.wall.loadMessage" data-action-url="<?= Url::to(['/mail/mail', 'id' => $message->id])?>" data-message-id="<?= $message->id ?>">
            <div class="media">
                <div class="media-left pull-left">
                    <?= Image::widget(['user' => $message->getLastEntry()->user, 'width' => '32', 'link' => false])?>
                </div>

                <div class="media-body text-break">
                    <h4 class="media-heading">
                        <?= Html::encode($message->getLastEntry()->user->displayName); ?> <small><?= TimeAgo::widget(['timestamp' => $message->updated_at]); ?></small>
                    </h4>
                    <h5>
                        <?= Html::encode(Helpers::truncateText($message->title, 75)); ?>
                    </h5>

                    <?= Html::encode($message->getPreview()) ?>

                    <?= Label::danger(Yii::t('MessageModule.views_mail_index', 'New'))
                        ->cssClass('new-message-badge')->style((!$userMessage->isUnread() ? 'display:none' : '')); ?>
                </div>
                <div class="pull-right">
                    <?php foreach ($message->users as $user) : ?>
                        <?= Image::widget(['user' => $user, 'showTooltip' => true, 'width' => '12', 'link' => false])?>
                    <?php endforeach; ?>
                </div>
            </div>
        </a>
    </li>
<?php endif; ?>
