<?php

namespace zikwall\easyonline\modules\user\events;

use yii\base\Event;
use zikwall\easyonline\modules\core\components\ActiveRecord;
use zikwall\easyonline\modules\user\models\User;

class FollowEvent extends Event
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var ActiveRecord the followed item
     */
    public $target;

}
