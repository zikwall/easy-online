<?php

namespace zikwall\easyonline\modules\user\modules\friendship\widgets;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;

/**
 * Displays a membership button between the current and given user.
 *
 * @author luke
 */
class FriendshipButton extends \yii\base\Widget
{

    /**
     * @var User the target user
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->getModule('friendship')->getIsEnabled()) {
            return;
        }
        
        // Do not display a buttton if user is it self or guest
        if ($this->user->isCurrentUser() || \Yii::$app->user->isGuest) {
            return;
        }

        return $this->render('friendshipButton', array(
            'user' => $this->user,
            'friendshipState' => Friendship::getStateForUser(Yii::$app->user->getIdentity(), $this->user)
        ));
    }

}
