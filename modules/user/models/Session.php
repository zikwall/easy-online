<?php

namespace zikwall\easyonline\modules\user\models;

use zikwall\easyonline\modules\core\components\ActiveRecord;

/**
 * @property string $id
 * @property integer $expire
 * @property integer $user_id
 * @property string $data
 *
 * @property User[] $user
 *
 */
class Session extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_http_session}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
