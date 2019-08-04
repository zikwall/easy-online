<?php

namespace zikwall\easyonline\modules\user\modules\friendship\controllers;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;
use zikwall\easyonline\modules\user\widgets\UserListBox;

class ListController extends \zikwall\easyonline\modules\core\components\base\Controller
{

    public function actionIndex()
    {
        return $this->render('test', [
            'text' => Yii::t("FriendshipModule.base", "<strong>Pending</strong> friend requests")
        ]);
    }

    public function actionPopup()
    {
        $user = User::findOne(['id' => Yii::$app->request->get('userId')]);
        if ($user === null) {
            throw new \yii\web\HttpException(404, 'Could not find user!');
        }

        $query = Friendship::getFriendsQuery($user);

        $title = '<strong>' . Yii::t('FriendshipModule.base', "Friends") . '</strong>';
        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

}
