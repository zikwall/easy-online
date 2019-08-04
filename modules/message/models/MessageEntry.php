<?php

namespace zikwall\easyonline\modules\message\models;

use zikwall\easyonline\modules\message\live\NewUserMessage;
use zikwall\easyonline\modules\message\live\UserMessageDeleted;
use zikwall\easyonline\modules\message\notifications\MailNotificationCategory;
use Yii;
use zikwall\easyonline\modules\core\components\ActiveRecord;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\models\Setting;
use zikwall\easyonline\modules\message\models\Message;

class MessageEntry extends ActiveRecord
{
    public static function tableName()
    {
        return 'message_entry';
    }

    public static function createForMessage(Message $message, User $user, $content)
    {
        return new static([
            'message_id' => $message->id,
            'user_id' => $user->id,
            'content' => $content
        ]);
    }

    public function rules()
    {
        return [
            [['message_id', 'user_id', 'content'], 'required'],
            [['message_id', 'user_id', 'file_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::class, ['id' => 'message_id']);
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {

            // Updates the updated_at attribute
            $this->message->save();
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        RichText::postProcess($this->content, $this);
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    public function afterDelete()
    {
        foreach ($this->message->users as $user) {
            Yii::$app->live->send(new UserMessageDeleted([
                'contentContainerId' => $user->contentcontainer_id,
                'message_id' => $this->message_id,
                'entry_id' => $this->id,
                'user_id' => $user->id
            ]));
        }


        parent::afterDelete();
    }

    public function getSnippet()
    {

        $snippet = "";
        $lines = explode("\n", $this->content);

        if (isset($lines[0]))
            $snippet .= $lines[0] . "\n";
        if (isset($lines[1]))
            $snippet .= $lines[1] . "\n";

        return $snippet;
    }

    public function notify()
    {
        $senderName = $this->user->displayName;
        
        foreach ($this->message->users as $user) {

            Yii::$app->live->send(new NewUserMessage([
                'contentContainerId' => $user->contentcontainer_id,
                'message_id' => $this->message_id,
                'user_id' => $user->id
            ]));

            /* @var $mailTarget BaseTarget */
            $mailTarget = Yii::$app->notification->getTarget(MailTarget::class);

            if (!$mailTarget || !$mailTarget->isCategoryEnabled(new MailNotificationCategory(), $user)) {
                return;
            }

            if ($user->id == $this->user_id) {
                continue;
            }

            Yii::setAlias('@MessageModule', Yii::$app->getModule('mail')->getBasePath());

            Yii::$app->i18n->setUserLocale($user);

            $mail = Yii::$app->mailer->compose([
                'html' => '@MessageModule/views/emails/NewMessageEntry',
                'text' => '@MessageModule/views/emails/plaintext/NewMessageEntry'
            ], [
                'message' => $this->message,
                'entry' => $this,
                'user' => $user,
                'sender' => $this->user,
                'originator' => $this->message->originator,
            ]);

            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($user->email);
            $mail->setSubject(Yii::t('MessageModule.models_MessageEntry', 'New message in discussion from %displayName%', array('%displayName%' => $senderName)));
            $mail->send();

            Yii::$app->i18n->autosetLocale();

        }
    }

    public function canEdit()
    {
        return $this->created_by == Yii::$app->user->id;
    }
}
