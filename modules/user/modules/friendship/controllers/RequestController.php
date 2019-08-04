<?php

namespace zikwall\easyonline\modules\user\modules\friendship\controllers;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;

class RequestController extends \zikwall\easyonline\modules\core\components\base\Controller
{
    public function actionAdd()
    {
        //$this->forcePostRequest();

        $friend = User::findOne(['id' => Yii::$app->request->get('userId')]);

        if ($friend === null) {
            throw new \yii\web\HttpException(404, 'User not found!');
        }

        Friendship::add(Yii::$app->user->getIdentity(), $friend);

        return $this->redirect($friend->getUrl());
    }

    public function actionDelete()
    {
        //$this->forcePostRequest();

        $friend = User::findOne(['id' => Yii::$app->request->get('userId')]);

        if ($friend === null) {
            throw new \yii\web\HttpException(404, 'User not found!');
        }

        Friendship::cancel(Yii::$app->user->getIdentity(), $friend);

        return $this->redirect($friend->getUrl());
    }

}
