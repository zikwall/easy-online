<?php

namespace zikwall\easyonline\modules\user\models\forms;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\libs\UUID;
use zikwall\easyonline\modules\user\authclient\Password;
use zikwall\easyonline\modules\user\models\User;

class AccountRecoverPassword extends \yii\base\Model
{
    public $verifyCode;
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'canRecoverPassword'],
            ['verifyCode', 'captcha', 'captchaAction' => '/user/auth/captcha'],
            ['email', 'exist',
                'targetClass' => User::class,
                'targetAttribute' => 'email',
                'message' => Yii::t('UserModule.forms_AccountRecoverPasswordForm', '{attribute} "{value}" was not found!')
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('UserModule.forms_AccountRecoverPasswordForm', 'E-Mail'),
        ];
    }

    /**
     * Проверяет, можно ли восстановить пароль пользователей.
     */
    public function canRecoverPassword($attribute, $params)
    {

        if ($this->email != "") {
            $user = User::findOne(['email' => $this->email]);
            $passwordAuth = new Password();

            if ($user != null && $user->auth_mode !== $passwordAuth->getId()) {
                $this->addError($attribute, Yii::t('UserModule.forms_AccountRecoverPasswordForm', Yii::t('UserModule.forms_AccountRecoverPasswordForm', "Password recovery is not possible on your account type!")));
            }
        }
    }

    /**
     * Отправляет пользователю новый пароль по E-Mail
     */
    public function recover()
    {
        $user = User::findOne(['email' => $this->email]);

        // Переключиться на язык пользователя - если указано
        if ($user->language !== "") {
            Yii::$app->language = $user->language;
        }

        $token = UUID::v4();
        Yii::$app->getModule('user')->settings->contentContainer($user)->set('passwordRecoveryToken', $token . '.' . time());

        $mail = Yii::$app->mailer->compose([
            'html' => '@easyonline/modules/user/views/mails/RecoverPassword',
            'text' => '@easyonline/modules/user/views/mails/plaintext/RecoverPassword'
        ], [
            'user' => $user,
            'linkPasswordReset' => Url::to(["/user/password-recovery/reset", 'token' => $token, 'guid' => $user->guid], true)
        ]);

        $mail->setTo($user->email);
        $mail->setSubject(Yii::t('UserModule.forms_AccountRecoverPasswordForm', 'Password Recovery'));
        $mail->send();

        return true;
    }

}
