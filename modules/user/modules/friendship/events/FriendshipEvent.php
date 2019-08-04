<?php

namespace zikwall\easyonline\modules\user\modules\friendship\events;

use yii\base\Event;
use zikwall\easyonline\modules\user\models\User;

class FriendshipEvent extends Event
{
    /**
     * @var User first user
     */
    public $user1;

    /**
     * @var User second user
     */
    public $user2;

}
