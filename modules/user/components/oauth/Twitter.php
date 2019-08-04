<?php

namespace zikwall\easyonline\modules\user\components\oauth;

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\UserOauthKey;

class Twitter extends \yii\authclient\clients\Twitter
{
    public function getViewOptions()
    {
        return [
            'popupWidth' => 900,
            'popupHeight' => 500
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('account/verify_credentials.json', 'GET');

        $return_attributes = [
            'User' => [
                'email' => null,
                'username' => $attributes['name'],
                //'photo' => '',
                //'sex' => User::SEX_MALE
            ],
            'provider_user_id' => $attributes['id'],
            'provider_id' => UserOauthKey::getAvailableClients()['twitter'],
        ];

        return $return_attributes;
    }
}
