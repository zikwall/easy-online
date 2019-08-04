<?php

namespace zikwall\easyonline\modules\user\modules\friendship\widgets;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;

class FriendsPanel extends \yii\base\Widget
{

    /**
     * @var User the target user
     */
    public $user;

    /**
     * @var int limit of friends to display
     */
    public $limit = 30;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->getModule('user')->getModule('friendship')->getIsEnabled()) {
            return;
        }

        $querz = Friendship::getFriendsQuery($this->user);

        $totalCount = $querz->count();
        $friends = $querz->limit($this->limit)->all();

        return $this->render('friendsPanel', array(
            'friends' => $friends,
            'friendsShowLimit' => $this->limit,
            'totalCount' => $totalCount,
            'limit' => $this->limit,
            'user' => $this->user,
        ));
    }

}
