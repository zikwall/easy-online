<?php

use zikwall\easyonline\modules\user\widgets\Image;
use zikwall\easyonline\modules\ui\widgets\ModalButton;
use zikwall\easyonline\modules\core\widgets\TimeAgo;
use zikwall\easyonline\modules\core\libs\Html;

/* @var $entry \zikwall\easyonline\modules\message\models\MessageEntry */
/* @var $options array */

?>

<?= Html::beginTag('div', $options) ?>

<div class="media">

    <span class="pull-left">
        <?= Image::widget(['user' => $entry->user]) ?>
    </span>

    <?php if ($entry->canEdit()): ?>
        <div class="pull-right">
            <?= ModalButton::asLink()->icon('fa-pencil-square-o')->load( ["/mail/mail/edit-entry", 'id' => $entry->id]) ?>
        </div>
    <?php endif; ?>

    <div class="media-body">
        <h4 class="media-heading" style="font-size: 14px;"><?= Html::encode($entry->user->displayName); ?>
            <small><?= TimeAgo::widget(['timestamp' => $entry->created_at]); ?></small>
        </h4>
    </div>
    <div style="margin-left:50px">
        <span class="content">
            <?= $entry->content; ?>
        </span>
    </div>

</div>

<hr>

<?= Html::endTag('div') ?>


