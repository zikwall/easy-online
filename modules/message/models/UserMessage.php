<?php

namespace zikwall\easyonline\modules\message\models;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\components\ActiveRecord;

class UserMessage extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_message';
    }

    public function rules()
    {
        return [
            [['message_id', 'user_id'], 'required'],
            [['message_id', 'user_id', 'is_originator', 'created_by', 'updated_by'], 'integer'],
            [['last_viewed', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getMessage()
    {
        return $this->hasOne(Message::class, ['id' => 'message_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'message_id' => Yii::t('MessageModule.base', 'Message'),
            'user_id' => Yii::t('MessageModule.base', 'User'),
            'is_originator' => Yii::t('MessageModule.base', 'Is Originator'),
            'last_viewed' => Yii::t('MessageModule.base', 'Last Viewed'),
            'created_at' => Yii::t('MessageModule.base', 'Created At'),
            'created_by' => Yii::t('MessageModule.base', 'Created By'),
            'updated_at' => Yii::t('MessageModule.base', 'Updated At'),
            'updated_by' => Yii::t('MessageModule.base', 'Updated By'),
        ];
    }

    public static function getNewMessageCount($userId = null)
    {
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }

        return static::getByUser($userId)
            ->andWhere("message.updated_at > user_message.last_viewed OR user_message.last_viewed IS NULL")
            ->andWhere(["<>", 'message.updated_by', $userId])->count();
    }

    public static function getByUser($userId = null, $orderBy = 'message.updated_at DESC')
    {
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }

        return static::find()->joinWith('message')
            ->where(['user_message.user_id' => $userId])
            ->orderBy('message.updated_at DESC');

    }

    public function isUnread($userId = null)
    {
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }

        return $this->message->updated_at > $this->last_viewed && $this->message->getLastEntry()->user->id != $userId;
    }
}
