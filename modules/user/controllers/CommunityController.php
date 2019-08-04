<?php

namespace zikwall\easyonline\modules\user\controllers;

use zikwall\easyonline\modules\user\components\BaseAccountController;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;

class CommunityController extends BaseAccountController
{
    public function actionIndex()
    {
        return $this->actionMy();
    }

    public function actionMy()
    {
        \Yii::$app->cache->flush();

        $userCommunities = Membership::getUserCommunities($this->getUser()->id);
        $kindsOfCommunities = $this->getKindsOfCommunities($userCommunities);

        return $this->render('my', [
            'user' => $user,
            'kindsOfCommunities' => $kindsOfCommunities
        ]);
    }

    public function getKindsOfCommunities($userCommunities)
    {
        $disabled = [];
        $enabled = [];
        $archived = [];

        foreach($userCommunities as $community) {
            switch($community->status) {
                case Community::STATUS_DISABLED:
                    array_push($disabled, $community);
                    break;

                case Community::STATUS_ENABLED:
                    array_push($enabled, $community);
                    break;

                case Community::STATUS_ARCHIVED:
                    array_push($archived, $community);
                    break;
            }
        }

        return [
            Community::STATUS_DISABLED => $disabled,
            Community::STATUS_ENABLED => $enabled,
            Community::STATUS_ARCHIVED => $archived
        ];
    }
}
