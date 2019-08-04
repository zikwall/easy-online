<?php

namespace zikwall\easyonline\modules\core\components\mail;

use Yii;

class Mailer extends \yii\swiftmailer\Mailer
{
    public $messageClass = 'zikwall\easyonline\modules\core\components\mail\Message';

    public function compose($view = null, array $params = array())
    {
        $message = parent::compose($view, $params);
        if (empty($message->getFrom())) {
            $message->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
        }

        return $message;
    }

}
