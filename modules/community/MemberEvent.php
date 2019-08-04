<?php

namespace zikwall\easyonline\modules\community;

use yii\base\Event;

class MemberEvent extends Event
{
    /**
     * @var models\Community
     */
    public $community;

    /**
     * @var \zikwall\easyonline\modules\user\models\User
     */
    public $user;

}
