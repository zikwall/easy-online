<?php

namespace zikwall\easyonline\modules\user\models;

use zikwall\easyonline\modules\core\behaviors\PolymorphicRelation;
use zikwall\easyonline\modules\user\events\FollowEvent;
use zikwall\easyonline\modules\activity\models\Activity;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\notifications\Followed;

/**
 * This is the model class for table "user_follow".
 *
 * @property integer $id
 * @property string $object_model
 * @property integer $object_id
 * @property integer $user_id
 * @property integer $send_notifications
 */
class Follow extends \yii\db\ActiveRecord
{

    /**
     * @event \zikwall\easyonline\modules\user\events\FollowEvent
     */
    const EVENT_FOLLOWING_CREATED = 'followCreated';

    /**
     * @event \zikwall\easyonline\modules\user\events\FollowEvent
     */
    const EVENT_FOLLOWING_REMOVED = 'followRemoved';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_follow}}';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Set send_notifications to 0 by default
        if ($this->send_notifications === null) {
            $this->send_notifications = 0;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => PolymorphicRelation::class,
                'mustBeInstanceOf' => [
                    \yii\db\ActiveRecord::class,
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_model', 'object_id', 'user_id'], 'required'],
            [['object_id', 'user_id'], 'integer'],
            [['send_notifications'], 'boolean'],
            [['object_model'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     *
     * ToDo: create notifications
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert && $this->object_model == User::class) {

            /*\zikwall\easyonline\modules\user\notifications\Followed::instance()
                    ->from($this->user)
                    ->about($this)
                    ->send($this->getTarget());

            \zikwall\easyonline\modules\user\activities\UserFollow::instance()
                    ->from($this->user)
                    ->container($this->user)
                    ->about($this)
                    ->save();*/
        }

        $this->trigger(Follow::EVENT_FOLLOWING_CREATED, new FollowEvent(['user' => $this->user, 'target' => $this->getTarget()]));

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $this->trigger(Follow::EVENT_FOLLOWING_REMOVED, new FollowEvent(['user' => $this->user, 'target' => $this->getTarget()]));

        // ToDo: Handle this via event of User Module
        /*if ($this->object_model == User::class) {
            $notification = new Followed();
            $notification->originator = $this->user;
            $notification->delete($this->getTarget());
        }*/

        return parent::beforeDelete();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getTarget()
    {
        $targetClass = $this->object_model;
        if ($targetClass != "") {
            return $targetClass::findOne(['id' => $this->object_id]);
        }
        return null;
    }


    /**
     * Возвращает всех активных пользователей, следующих за заданной $ target record.
     * Если параметр $ withNotifications установлен, возвращается только последователь с заданным параметром send_notifications.
     *
     */
    public static function getFollowersQuery(\yii\db\ActiveRecord $target, $withNotifications = null)
    {
        $subQuery = self::find()
            ->where(['user_follow.object_model' => $target->className(), 'user_follow.object_id' => $target->getPrimaryKey()])
            ->andWhere('user_follow.user_id=user.id');
        
        if ($withNotifications === true) {
            $subQuery->andWhere(['user_follow.send_notifications' => 1]);
        } else if ($withNotifications === false) {
            $subQuery->andWhere(['user_follow.send_notifications' => 0]);
        }
        
        return User::find()->active()->andWhere(['exists', $subQuery]);
    }

}
