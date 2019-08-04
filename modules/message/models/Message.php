<?php

namespace zikwall\easyonline\modules\message\models;

use zikwall\easyonline\modules\core\helpers\Helpers;
use Yii;
use zikwall\easyonline\modules\message\live\NewUserMessage;
use zikwall\easyonline\modules\message\notifications\ConversationNotificationCategory;
use zikwall\easyonline\modules\core\components\ActiveRecord;
use zikwall\easyonline\modules\core\models\Setting;
use zikwall\easyonline\modules\user\models\User;
use yii\db\Expression;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return 'message';
    }

    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getEntries($from = null)
    {
        $query = $this->hasMany(MessageEntry::class, ['message_id' => 'id']);
        $query->addOrderBy(['created_at' => SORT_ASC]);

        if ($from) {
            $query->andWhere(['>', 'message_entry.id', $from]);
        }

        return $query;
    }

    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
                        ->viaTable('user_message', ['message_id' => 'id']);
    }

    public function getUserMessage($userId = null)
    {
        if (!$userId) {
            $userId = Yii::$app->user->id;
        }

        return UserMessage::findOne([
            'user_id' => $userId,
            'message_id' => $this->id
        ]);
    }

    public function isParticipant($user)
    {
        foreach ($this->users as $participant) {
            if ($participant->guid === $user->guid) {
                return true;
            }
        }
        return false;
    }

    public function getOriginator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => Yii::t('MessageModule.base', 'Title'),
            'created_at' => Yii::t('MessageModule.base', 'Created At'),
            'created_by' => Yii::t('MessageModule.base', 'Created By'),
            'updated_at' => Yii::t('MessageModule.base', 'Updated At'),
            'updated_by' => Yii::t('MessageModule.base', 'Updated By'),
        );
    }

    public function getLastEntry()
    {
        return MessageEntry::find()->where(['message_id' => $this->id])->orderBy('created_at DESC')->limit(1)->one();
    }

    public function deleteEntry($entry)
    {
        if ($entry->message->id == $this->id) {
            if (count($this->entries) > 1) {
                $entry->delete();
            } else {
                $this->delete();
            }
        }
    }

    public function leave($userId)
    {
        $userMessage = UserMessage::findOne(array(
                    'message_id' => $this->id,
                    'user_id' => $userId
        ));

        if (count($this->users) > 2) {
            $userMessage->delete();
        } else {
            $this->delete();
        }
    }

    public function seen($userId)
    {
        // Update User Message Entry
        $userMessage = UserMessage::findOne(array(
                    'user_id' => $userId,
                    'message_id' => $this->id
        ));
        if ($userMessage !== null) {
            $userMessage->last_viewed = new Expression('NOW()');
            $userMessage->save();
        }
    }

    public function delete()
    {
        foreach (MessageEntry::findAll(array('message_id' => $this->id)) as $messageEntry) {
            $messageEntry->delete();
        }

        foreach (UserMessage::findAll(array('message_id' => $this->id)) as $userMessage) {
            $userMessage->delete();
        }

        parent::delete();
    }

    public function notify($user)
    {
        /* @var $mailTarget BaseTarget */
        $mailTarget = Yii::$app->notification->getTarget(MailTarget::class);

        if (!$mailTarget || !$mailTarget->isCategoryEnabled(new ConversationNotificationCategory(), $user)) {
            return;
        }

        $andAddon = "";
        if (count($this->users) > 2) {
            $counter = count($this->users) - 1;
            $andAddon = Yii::t('MessageModule.models_Message', "and {counter} other users", ["{counter}" => $counter]);
        }

        Yii::setAlias('@MessageModule', Yii::$app->getModule('mail')->getBasePath());

        Yii::$app->i18n->setUserLocale($user);

        $mail = Yii::$app->mailer->compose([
            'html' => '@MessageModule/views/emails/NewMessage',
            'text' => '@MessageModule/views/emails/plaintext/NewMessage'
        ], [
            'message' => $this,
            'originator' => $this->originator,
            'andAddon' => $andAddon,
            'entry' => $this->getLastEntry(),
            'user' => $user,
        ]);

        $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
        $mail->setTo($user->email);
        $mail->setSubject(Yii::t('MessageModule.models_Message', 'New message from {senderName}', array("{senderName}" => \yii\helpers\Html::encode($this->originator->displayName))));
        $mail->send();

        Yii::$app->i18n->autosetLocale();
    }

    public function getPreview()
    {
        return RichText::preview($this->getLastEntry()->content, 300);
    }

    public function addRecepient(User $recipient, $originator = false)
    {
        $userMessage = new UserMessage([
            'message_id' => $this->id,
            'user_id' => $recipient->id
        ]);

        if ($originator) {
            $userMessage->is_originator = 1;
            $userMessage->last_viewed = new Expression('NOW()');
        }

        return $userMessage->save();

    }
}
