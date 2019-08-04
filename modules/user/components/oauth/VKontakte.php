<?php

namespace zikwall\easyonline\modules\user\components\oauth;

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\UserOauthKey;

class VKontakte extends \yii\authclient\clients\VKontakte
{
    /**
     * @inheritdoc
     */
    public function getViewOptions()
    {
        return [
            'popupWidth' => 900,
            'popupHeight' => 500
        ];
    }

    public function normalizeSex()
    {
        return [
            '1' => User::SEX_FEMALE,
            '2' => User::SEX_MALE
        ];
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('users.get.json', 'GET', [
            'fields' => implode(',', [
                'uid',
                'first_name',
                'last_name',
                //'photo_200',
                //'sex'
            ]),
        ]);

        $attributes = array_shift($attributes['response']);

        $return_attributes = [
            'User' => [
                'email' => (isset($this->accessToken->params['email'])) ? $this->accessToken->params['email'] : null,
                'username' => $attributes['uid'],
                //'photo' => $attributes['photo_200'],
                //'sex' => $this->normalizeSex()[$attributes['sex']],
                'firstname' => 'first_name', //
                'lastname' => 'last_name', //
            ],
            'provider_user_id' => $attributes['uid'],
            'provider_id' => UserOauthKey::getAvailableClients()['vkontakte'],
        ];

        return $return_attributes;
    }
}
