<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;

class ProfileEditButton extends \yii\base\Widget
{
    public $user;

    public function run()
    {
        if (Yii::$app->user->isGuest || !$this->user->isCurrentUser()) {
            return;
        }

        return $this->render('profileEditButton', array('user' => $this->user));
    }

}
