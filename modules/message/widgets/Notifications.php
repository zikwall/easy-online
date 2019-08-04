<?php

namespace zikwall\easyonline\modules\message\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;
use zikwall\easyonline\modules\message\models\UserMessage;

class Notifications extends Widget
{

    public function run()
    {
        return $this->render('notifications', [
            'newMailMessageCount' => UserMessage::getNewMessageCount()
        ]);
    }
}

?>
