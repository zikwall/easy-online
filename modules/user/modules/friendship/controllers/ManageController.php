<?php

namespace zikwall\easyonline\modules\user\modules\friendship\controllers;


use yii\data\ActiveDataProvider;

use zikwall\easyonline\modules\user\components\BaseAccountController;
use zikwall\easyonline\modules\user\modules\friendship\models\Friendship;
use zikwall\easyonline\modules\user\modules\friendship\models\SettingsForm;


class ManageController extends BaseAccountController
{
    public function actionIndex()
    {
        return $this->redirect(['list']);
    }

    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getFriendsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('list', [
                    'user' => $this->getUser(),
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionRequests()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getReceivedRequestsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('requests', [
                    'user' => $this->getUser(),
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionSentRequests()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Friendship::getSentRequestsQuery($this->getUser()),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('sent-requests', [
                    'user' => $this->getUser(),
                    'dataProvider' => $dataProvider
        ]);
    }

}
