<?php

namespace zikwall\easyonline\modules\message\widgets\wall;

use zikwall\easyonline\modules\core\widgets\JsWidget;
use yii\helpers\Url;

class ConversationView extends JsWidget
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'mail.wall.ConversationView';

    /**
     * @inheritdoc
     */
    public $id = 'mail-conversation-root';

    /**
     * @inheritdoc
     */
    public $init = true;

    /**
     * @var int
     */
    public $messageId;

    public function getData()
    {
        return [
            'message-id' => $this->messageId,
            'load-message-url' => Url::to(['/mail/mail/show']),
            'load-update-url' => Url::to(['/mail/mail/update'])
        ];
    }
}
