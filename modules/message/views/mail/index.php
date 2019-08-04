<?php

use zikwall\easyonline\modules\message\widgets\wall\ConversationView;

/* @var $messageId int */
/* @var $userMessages \zikwall\easyonline\modules\message\models\UserMessage[] */
/* @var $pagination \yii\data\Pagination */

?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('_conversation_chooser', [
                'userMessages' => $userMessages,
                'pagination' => $pagination,
                'activeMessageId' => $messageId
            ]) ?>
        </div>

        <div class="col-md-8 messages">
            <?= ConversationView::widget(['messageId' => $messageId]) ?>
        </div>
    </div>
</div>
