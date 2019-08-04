<?php

namespace zikwall\easyonline\modules\user\widgets;

/**
 * UserFollowerWidget lists all followers of the user
 */
class UserFollower extends \yii\base\Widget
{
    public $user;

    public function run()
    {
        return $this->render('userFollower', [
            'user' => $this->user
        ]);
    }
}

?>
