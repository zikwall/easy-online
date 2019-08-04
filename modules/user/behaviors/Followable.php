<?php

namespace zikwall\easyonline\modules\user\behaviors;

use Yii;
use yii\base\Behavior;
use zikwall\easyonline\modules\user\models\Follow;
use zikwall\easyonline\modules\user\models\User;

class Followable extends Behavior
{

    private $_followerCache = [];

    /**
     * @param $userId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getFollowRecord($userId)
    {
        $userId = ($userId instanceof User) ? $userId->id : $userId;
        return Follow::find()->where([
            'object_model' => $this->owner->className(),
            'object_id' => $this->owner->getPrimaryKey(),
            'user_id' => $userId
        ])->one();
    }

    public function follow($userId = null, $withNotifications = true)
    {
        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == "") {
            $userId = Yii::$app->user->id;
        }

        // User cannot follow himself
        if ($this->owner instanceof User && $this->owner->id == $userId) {
            return false;
        }

        $follow = $this->getFollowRecord($userId);
        if ($follow === null) {
            $follow = new Follow(['user_id' => $userId]);
            $follow->setPolyMorphicRelation($this->owner);
        }

        /*$follow->send_notifications = $withNotifications;*/

        if (!$follow->save()) {
            return false;
        }

        return true;
    }

    public function unfollow($userId = null)
    {
        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == "") {
            $userId = Yii::$app->user->id;
        }

        $record = $this->getFollowRecord($userId);
        if ($record !== null) {
            if ($record->delete()) {
                return true;
            }
        } else {
            // Not follow this object
            return false;
        }

        return false;
    }

    public function isFollowedByUser($userId = null, $withNotifications = false)
    {
        if ($userId instanceof User) {
            $userId = $userId->id;
        } else if (!$userId || $userId == "") {
            $userId = \Yii::$app->user->id;
        }

        if (!isset($this->_followerCache[$userId])) {
            $this->_followerCache[$userId] = $this->getFollowRecord($userId);
        }

        $record = $this->_followerCache[$userId];

        if ($record) {
            if ($withNotifications && $record->send_notifications == 1) {
                return true;
            } elseif (!$withNotifications) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the number of users which are followers of this object.
     *
     * @return int
     */
    public function getFollowerCount()
    {
        return Follow::find()->where([
            'object_id' => $this->owner->getPrimaryKey(),
            'object_model' => $this->owner->className()
        ])->count();
    }

    /**
     * @param null $query
     * @param bool $withNotification
     * @param bool $returnQuery
     * @return array|null|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function getFollowers($query = null, $withNotification = false, $returnQuery = false)
    {

        if ($query === null) {
            $query = User::find();
        }

        $query->leftJoin(Follow::tableName(), 'user.id = '.Follow::tableName().'.user_id AND '.Follow::tableName().'.object_id=:object_id AND '.Follow::tableName().'.object_model = :object_model', [
            ':object_model' => $this->owner->className(),
            ':object_id' => $this->owner->getPrimaryKey(),
        ]);

        $query->andWhere(Follow::tableName().'.user_id IS NOT null');

        if ($withNotification) {
            $query->andWhere(Follow::tableName().'.send_notifications=1');
        }

        if ($returnQuery) {
            return $query;
        }

        return $query->all();
    }

    /**
     * Returns the number of follows the owner object performed.
     * This is only affects User owner objects!
     *
     * @param string $objectModel HActiveRecord Classname to restrict Object Classes to (e.g. User)
     * @return int
     */
    public function getFollowingCount($objectModel)
    {
        return Follow::find()->where([
            'user_id' => $this->owner->getPrimaryKey(),
            'object_model' => $objectModel
        ])->count();
    }

    /**
     * Returns an array of object which the owner object follows.
     * This is only affects User owner objects!
     *
     * E.g. Get list of spaces which are the user follows.
     *
     * @param CDbCriteria $eCriteria e.g. for limit the result
     * @param string $objectModel HActiveRecord Classname to restrict Object Classes to (e.g. User)
     * @return Array
     */
    public function getFollowingObjects($query)
    {
        $query->leftJoin(Follow::tableName(), 'user.id='.Follow::tableName().'.object_id AND '.Follow::tableName().'.object_model=:object_model', [
            'object_model' => $this->owner->className()
        ]);
        $query->andWhere([Follow::tableName().'.user_id' => $this->owner->id]);

        return $query->all();
    }

}
