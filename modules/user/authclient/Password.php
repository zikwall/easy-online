<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2016 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */
namespace zikwall\easyonline\modules\user\authclient;

use zikwall\easyonline\modules\user\models\User;

/**
 * Standard password authentication client
 * 
 * @since 1.1
 */
class Password extends BaseFormAuth implements interfaces\PrimaryClient
{

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 'local';
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'password';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return 'Password';
    }

    /**
     * @inheritdoc
     */
    public function getUserTableIdAttribute()
    {
        return 'id';
    }

    /**
     * @inheritdoc
     */
    public function auth()
    {
        $user = User::find()->where(['username' => $this->login->username])->orWhere(['email' => $this->login->username])->one();

        if ($user !== null && $user->currentPassword !== null && $user->currentPassword->validatePassword($this->login->password)) {
            $this->setUserAttributes(['id' => $user->id]);
            return true;
        }

        return false;
    }

}
