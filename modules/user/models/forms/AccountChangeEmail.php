<?php

namespace zikwall\easyonline\modules\user\models\forms;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\components\CheckPasswordValidator;

class AccountChangeEmail extends \yii\base\Model
{

    /**
     * @var string the users password
     */
    public $currentPassword;

    /**
     * @var string the users new email address
     */
    public $newEmail;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['newEmail', 'required'],
            ['newEmail', 'email'],
            ['newEmail', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class, 'message' => '{attribute} "{value}" is already in use!'],
        ];

        if (CheckPasswordValidator::hasPassword()) {
            $rules[] = ['currentPassword', CheckPasswordValidator::class];
            $rules[] = ['currentPassword', 'required'];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'currentPassword' => Yii::t('UserModule.forms_AccountChangeEmailForm', 'Current password'),
            'newEmail' => Yii::t('UserModule.forms_AccountChangeEmailForm', 'New E-Mail address'),
        );
    }

    /**
     * Sends Change E-Mail E-Mail
     */
    public function sendChangeEmail($approveUrl = '')
    {
        $user = Yii::$app->user->getIdentity();

        $token = md5(Yii::$app->settings->get('secret') . $user->guid . $this->newEmail);

        $mail = Yii::$app->mailer->compose([
            'html' => '@easyonline/modules/user/views/mails/ChangeEmail',
            'text' => '@easyonline/modules/user/views/mails/plaintext/ChangeEmail'
                ], [
            'user' => $user,
            'newEmail' => $this->newEmail,
            'approveUrl' => Url::to([empty($approveUrl) ? "/user/account/change-email-validate" : $approveUrl, 'email' => $this->newEmail, 'token' => $token], true),
        ]);
        $mail->setTo($this->newEmail);
        $mail->setSubject(Yii::t('UserModule.forms_AccountChangeEmailForm', 'E-Mail change'));
        $mail->send();

        return true;
    }

}
