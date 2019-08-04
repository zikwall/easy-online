<?php
namespace zikwall\easyonline\modules\user\components;

use yii\db\ActiveQuery;

class ActiveQueryUser extends ActiveQuery
{

    public function active()
    {
        //$this->andWhere(['user.status' => \zikwall\easyonline\modules\user\models\User::STATUS_ENABLED]);
        return $this;
    }

    public function visible()
    {
        //$this->trigger(self::EVENT_CHECK_VISIBILITY, new ActiveQueryEvent(['query' => $this]));
        return $this->active();
    }

    public function defaultOrder()
    {
        $this->joinWith('profile');
        $this->addOrderBy(['profile.lastname' => SORT_ASC]);
        return $this;
    }
}
