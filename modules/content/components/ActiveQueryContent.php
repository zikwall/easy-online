<?php

namespace zikwall\easyonline\modules\content\components;

use Yii;
use zikwall\easyonline\modules\user\models\User;

class ActiveQueryContent extends \yii\db\ActiveQuery
{
    const USER_RELATED_SCOPE_OWN = 1;
    const USER_RELATED_SCOPE_SPACES = 2;
    const USER_RELATED_SCOPE_FOLLOWED_SPACES = 3;
    const USER_RELATED_SCOPE_FOLLOWED_USERS = 4;
    const USER_RELATED_SCOPE_OWN_PROFILE = 5;

    /**
     * @param null $user
     * @return $this
     * @throws \Throwable
     */
    public function readable($user = null) : self
    {
        if ($user === null && !Yii::$app->user->isGuest) {
            $user = Yii::$app->user->getIdentity();
        }

        $this->joinWith(['content', 'content.contentContainer', 'content.createdBy']);

        return $this;
    }

    /**
     * @param $container
     * @return $this
     */
    public function contentContainer($container) : self
    {
        if ($container === null) {
            $this->joinWith(['content', 'content.contentContainer', 'content.createdBy']);
            $this->andWhere(['IS', 'contentcontainer.pk', new \yii\db\Expression('NULL')]);
        } else {
            $this->joinWith(['content', 'content.contentContainer', 'content.createdBy']);
            $this->andWhere(['contentcontainer.pk' => $container->id, 'contentcontainer.class' => $container->className()]);
        }

        return $this;
    }

    /**
     * @param array|string|\yii\db\ExpressionInterface $condition
     * @param array $params
     * @return $this
     */
    public function where($condition, $params = []) : self
    {
        return parent::andWhere($condition, $params);
    }

    /**
     * @param array $scopes
     * @param null $user
     * @return $this
     * @throws \Throwable
     */
    public function userRelated($scopes = array(), $user = null) : self
    {
        if ($user === null) {
            $user = Yii::$app->user->getIdentity();
        }

        $this->joinWith(['content', 'content.contentContainer']);

        $conditions = [];
        $params = [];

        if (in_array(self::USER_RELATED_SCOPE_OWN_PROFILE, $scopes)) {
            $conditions[] = 'contentcontainer.pk=:userId AND class=:userClass';
            $params[':userId'] = $user->id;
            $params[':userClass'] = $user->className();
        }

        if (in_array(self::USER_RELATED_SCOPE_SPACES, $scopes)) {
            $spaceMemberships = (new \yii\db\Query())
                    ->select("sm.id")
                    ->from('space_membership')
                    ->leftJoin('space sm', 'sm.id=space_membership.space_id')
                    ->where('space_membership.user_id=:userId AND space_membership.status=' . \humhub\modules\space\models\Membership::STATUS_MEMBER);
            $conditions[] = 'contentcontainer.pk IN (' . Yii::$app->db->getQueryBuilder()->build($spaceMemberships)[0] . ') AND contentcontainer.class = :spaceClass';
            $params[':userId'] = $user->id;
            $params[':spaceClass'] = Space::class;
        }

        if (in_array(self::USER_RELATED_SCOPE_OWN, $scopes)) {
            $conditions[] = 'content.created_by = :userId';
            $params[':userId'] = $user->id;
        }

        if (in_array(self::USER_RELATED_SCOPE_FOLLOWED_SPACES, $scopes)) {
            $spaceFollow = (new \yii\db\Query())
                    ->select("sf.id")
                    ->from('user_follow')
                    ->leftJoin('space sf', 'sf.id=user_follow.object_id AND user_follow.object_model=:spaceClass')
                    ->where('user_follow.user_id=:userId AND sf.id IS NOT NULL');
            $conditions[] = 'contentcontainer.pk IN (' . Yii::$app->db->getQueryBuilder()->build($spaceFollow)[0] . ') AND contentcontainer.class = :spaceClass';
            $params[':spaceClass'] = Space::class;
            $params[':userId'] = $user->id;
        }

        if (in_array(self::USER_RELATED_SCOPE_FOLLOWED_USERS, $scopes)) {
            $userFollow = (new \yii\db\Query())
                    ->select(["uf.id"])
                    ->from('user_follow')
                    ->leftJoin('user uf', 'uf.id=user_follow.object_id AND user_follow.object_model=:userClass')
                    ->where('user_follow.user_id=:userId AND uf.id IS NOT NULL');
            $conditions[] = 'contentcontainer.pk IN (' . Yii::$app->db->getQueryBuilder()->build($userFollow)[0] . ' AND contentcontainer.class=:userClass)';
            $params[':userClass'] = User::class;
            $params[':userId'] = $user->id;
        }

        if (count($conditions) != 0) {
            $this->andWhere("(" . join(') OR (', $conditions) . ")", $params);
        } else {
            // No results, when no selector given
            $this->andWhere('1=2');
        }

        return $this;
    }

}
