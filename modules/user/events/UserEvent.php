<?php

namespace zikwall\easyonline\modules\user\events;

class UserEvent extends \zikwall\easyonline\modules\core\components\Event
{
    /**
     * @var \zikwall\easyonline\modules\user\models\User the user
     */
    public $user;
}
