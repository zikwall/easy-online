<?php

namespace zikwall\easyonline\modules\message\models\forms;

use zikwall\easyonline\modules\message\models\Message;
use zikwall\easyonline\modules\message\models\UserMessage;
use Yii;
use yii\base\Model;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\message\permissions\SendMail;
use yii\helpers\Html;
use yii\helpers\Url;

class InviteParticipantForm extends Model
{
    /**
     * @var Message
     */
    public $message; // message

    /**
     * Parsed recipients in array of user objects
     *
     * @var array
     */
    public $recipients = [];

    /**
     * @var User[]
     */
    public $recipientUsers = [];

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            ['recipients', 'required'],
            ['recipients', 'checkRecipient']
        ];
    }

    public function attributeLabels()
    {
        return [
            'recipient' => Yii::t('MessageModule.forms_InviteRecipientForm', 'Recipient'),
        ];
    }

    public function checkRecipient($attribute, $params)
    {
        foreach ($this->recipients as $userGuid) {
            $user = User::findOne(['guid' => $userGuid]);
            if ($user) {
                $name = Html::encode($user->getDisplayName());
                if (Yii::$app->user->identity->is($user)) {
                    $this->addError($attribute, Yii::t('MessageModule.forms_InviteRecipientForm', "You cannot send a email to yourself!"));
                } else if ($this->message->isParticipant($user)) {
                    $this->addError($attribute, Yii::t('MessageModule.forms_InviteRecipientForm', "User {name} is already participating!", ['name' => $name]));
                } else if (!$user->can(SendMail::class) && !Yii::$app->user->isAdmin()){
                    $this->addError($attribute, Yii::t('MessageModule.forms_InviteRecipientForm', "You are not allowed to send user {name} is already!", ['name' => $name]));
                } else {
                    $this->recipientUsers[] = $user;
                }
            }
        }
    }

    public function getPickerUrl()
    {
        return Url::to(['/mail/mail/search-user', 'id' => $this->message->id]);
    }

    public function getUrl()
    {
        return Url::to(['/mail/mail/add-user', 'id' => $this->message->id]);
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->recipientUsers as $user) {
            $userMessage = new UserMessage([
                'message_id' => $this->message->id,
                'user_id' => $user->id,
                'is_originator' => 0
            ]);

            if ($userMessage->save()) {
                $this->message->notify($user);
            }
        }


        return true;
    }

    public function getRecipients()
    {
        return $this->recipients;
    }

}
