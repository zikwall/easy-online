<?php

namespace zikwall\easyonline\modules\message\widgets\wall;

use Yii;
use zikwall\easyonline\modules\message\models\MessageEntry;
use zikwall\easyonline\modules\core\widgets\JsWidget;
use yii\helpers\Url;

class ConversationEntry extends JsWidget
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'mail.wall.ConversationEntry';

    /**
     * @var MessageEntry
     */
    public $entry;

    public function run()
    {
        return $this->render('conversationEntry', [
            'entry' => $this->entry,
            'options' => $this->getOptions()
        ]);
    }

    public function getData()
    {
        return [
            'entry-id' => $this->entry->id,
            'delete-url' => Url::to(['/mail/mail/delete-entry', 'id' => $this->entry->id]),
        ];
    }

    public function getAttributes()
    {
        return [
            'class' => 'media message-conversation-entry'
        ];
    }
}
