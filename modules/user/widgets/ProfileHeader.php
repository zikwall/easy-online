<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;
use zikwall\easyonline\modules\user\controllers\ImageController;

class ProfileHeader extends \yii\base\Widget
{

    /**
     * @var User
     */
    public $user;

    /**
     * @var boolean is owner of the current profile
     */
    protected $isProfileOwner = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        /**
         * Try to autodetect current user by controller
         */
        if ($this->user === null) {
            $this->user = $this->getController()->getUser();
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $this->user->id) {
            $this->isProfileOwner = true;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $friendshipsEnabled = Yii::$app->getModule('friendship')->getIsEnabled();

        $countFriends = 0;

        if ($friendshipsEnabled) {
            $countFriends = Friendship::getFriendsQuery($this->user)->count();
        }
        $countFollowing = $this->user->getFollowingCount(User::class);

        return $this->render('profileHeader', array(
            'user' => $this->user,
            'isProfileOwner' => $this->isProfileOwner,
            'friendshipsEnabled' => $friendshipsEnabled,
            'followingEnabled' => !Yii::$app->getModule('user')->disableFollow,
            'countFriends' => $countFriends,
            'countFollowers' => $this->user->getFollowerCount(),
            'countFollowing' => $countFollowing,
        ));
    }
}

?>
