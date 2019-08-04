<?php

namespace zikwall\easyonline\modules\user\components\oauth;

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\UserOauthKey;

class GitHub extends \yii\authclient\clients\GitHub
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

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = implode(' ', [
                'user',
                'user:email',
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('user', 'GET');
        $emails = $this->api('user/emails', 'GET');

        $verifiedEmail = '';

        foreach ($emails as $email) {
            if ($email['verified'] && $email['primary']) {
                $verifiedEmail = $email['email'];
            }
        }

        $return_attributes = [
            'User' => [
                'email' => $verifiedEmail,
                'username' => $attributes['login'],
                //'photo' => $attributes['avatar_url'],
                //'sex' => User::SEX_MALE
            ],
            'provider_user_id' => $attributes['id'],
            'provider_id' => UserOauthKey::getAvailableClients()['github'],
        ];

        return $return_attributes;
    }

}
