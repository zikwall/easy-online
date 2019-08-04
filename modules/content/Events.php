<?php

namespace zikwall\easyonline\modules\content;

use Yii;
use zikwall\easyonline\modules\content\models\Content;
use zikwall\easyonline\modules\content\models\ContentContainer;

class Events extends \yii\base\BaseObject
{
    /**
     * ToDo: create user delete event handling
     *
     * @param $event
     * @return bool
     */
    public static function onUserDelete($event)
    {
        return true;
    }
}
