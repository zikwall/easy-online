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
    <li data-message-preview="<?= $message->id ?>" class="nim-dialog _im_dialog nim-dialog_classic nim-dialog_muted <?= $active ? 'selected' : ''?>"
        data-action-click="mail.wall.loadMessage"
        data-action-url="<?= Url::to(['/mail/mail', 'id' => $message->id])?>"
        data-message-id="<?= $message->id ?>"
    >
        <div class="nim-dialog--photo">
            <div class="nim-peer _online online _im_peer_online">
                <div class="nim-peer--photo-w">
                    <div class="nim-peer--photo _im_dialog_photo">
                        <a href="/id.kapitonov" class="_im_peer_target _online_reader" target="_blank">
                            <div class="im_grid">
                                <img alt="Андрей Капитонов" src="https://pp.userapi.com/c639624/v639624013/12f5f/K4qeDMzHqbk.jpg?ava=1" width="50" height="50">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="nim-dialog--content">
            <div class="nim-dialog--cw">
                <span role="link" class="blind_label" aria-label="Перейти к беседе: Андрей Капитонов"></span>
                <div class="nim-dialog--date _im_dialog_date"><?= TimeAgo::widget(['timestamp' => $message->updated_at]); ?></div>
                <div class="nim-dialog--name">
                    <span class="nim-dialog--name-w" aria-hidden="true">
                        <span class="_im_dialog_link"><?= Html::encode($message->getLastEntry()->user->displayName); ?></span>
                    </span>
                </div>
                <div class="nim-dialog--text-preview">
                    <span class="nim-dialog--preview _dialog_body" tabindex="0">
                        <span class="nim-dialog--preview nim-dialog--preview-attach">
                            <?= Html::encode($message->getPreview()) ?>
                        </span>
                    </span>
                </div>
                <label class="blind_label _im_unread_blind_label"></label>
                <div class="nim-dialog--unread _im_dialog_unread_ct" aria-hidden="true"></div>
            </div>
        </div>
    </li>
<?php endif; ?>
