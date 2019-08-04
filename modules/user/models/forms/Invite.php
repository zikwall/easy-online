<?php

namespace zikwall\easyonline\modules\user\models\forms;

use Yii;
use yii\base\Model;
use zikwall\easyonline\modules\user\models\User;

/**
 * Invite Form Model
 *
 * @since 1.1
 */
class Invite extends Model
{

    /**
     * @var string user's username or email address
     */
    public $emails;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emails'], 'required'],
            ['emails', 'checkEmails']
        ];
    }

    /**
     * Checks a comma separated list of e-mails which should invited.
     * E-Mails needs to be valid and not already registered.
     *
     * @param string $attribute
     * @param array $params
     */
    public function checkEmails($attribute, $params)
    {
        if ($this->$attribute != "") {
            foreach ($this->getEmails() as $email) {
                $validator = new \yii\validators\EmailValidator();
                if (!$validator->validate($email)) {
                    $this->addError($attribute, Yii::t('UserModule.invite', '{email} is not valid!', array("{email}" => $email)));
                    continue;
                }

                if (User::findOne(['email' => $email]) != null) {
                    $this->addError($attribute, Yii::t('UserModule.invite', '{email} is already registered!', array("{email}" => $email)));
                    continue;
                }
            }
        }
    }

    /**
     * E-Mails entered in form
     *
     * @return array the emails
     */
    public function getEmails()
    {
        $emails = [];
        foreach (explode(',', $this->emails) as $email) {
            $emails[] = trim($email);
        }

        return $emails;
    }

}
