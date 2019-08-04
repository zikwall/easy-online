<?php

namespace zikwall\easyonline\modules\user\models;

use Yii;
use yii\db\ActiveQuery;
use \zikwall\easyonline\modules\user\models\UserPicker;

class UserFilter extends User
{

    /**
     * @param null $user
     * @return null|\yii\web\IdentityInterface|static
     */
    public static function forUser($user = null)
    {
        if ($user == null) {
            $user = Yii::$app->user->getIdentity();
        }

        $userId = ($user instanceof User) ? $user->id : $user;
        return self::findIdentity($userId);
    }

    /**
     * @param null $keywords
     * @param null $maxResults
     * @param bool $friendsOnly
     * @param null $permission
     * @return array
     */
    public function getUserPickerResult($keywords = null, $maxResults = null, $friendsOnly = false, $permission = null)
    {
        if (!Yii::$app->getModule('friendship')->getIsEnabled()) {
            $users = $this->getUserByFilter($keywords, $maxResults);
            return UserPicker::asJSON($users, $permission);
        }

        $friends = $this->getFriendsByFilter($keywords, $maxResults);

        $jsonResult = UserPicker::asJSON($friends, $permission);

        if (!$friendsOnly && count($friends) < $maxResults) {
            $additionalUser = [];
            foreach($this->getUserByFilter($keywords, ($maxResults - count($friends)), $permission) as $user) {
                if (!$this->containsUser($friends, $user)) {
                    $additionalUser[] = $user;
                }
            }
            $jsonResult = array_merge($jsonResult, UserPicker::asJSON($additionalUser));
        }

        return $jsonResult;
    }

    /**
     * @param $userArr
     * @param User $user
     * @return bool
     */
    private function containsUser($userArr, User $user)
    {
        foreach($userArr as $currentUser) {
            if ($currentUser->id === $user->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Поиск всех активных пользователей по ключевым словам и разрешениям
     *
     * @param null $keywords
     * @param null $maxResults
     * @param null $permission
     * @return array
     */
    public static function getUserByFilter($keywords = null, $maxResults = null, $permission = null)
    {
        return self::filter(User::find(), $keywords, $maxResults, $permission);
    }

    /**
     * Поиск всех друзей, имеющих активный статус пользователя
     *
     * @param null $keywords
     * @param null $maxResults
     * @param null $permission
     * @return array
     */
    public function getFriendsByFilter($keywords = null, $maxResults = null, $permission = null)
    {
        return self::filter($this->getFriends(), $keywords, $maxResults, $permission);
    }

    /**
     * Возвращает массив моделей пользователей, отфильтрованных по ключевому слову  и разрешению. Эти фильтры
     * добавляются к предоставленному запросу. Фильтр ключевых слов можно использовать для фильтрации пользователей
     * по электронной почте, имени пользователя, имени, фамилии и т.д. (при своей добавлении).
     *
     * @param $query
     * @param null $keywords
     * @param null $maxResults
     * @param null $permission
     * @param null $active
     * @return array
     */
    public static function filter($query, $keywords = null, $maxResults = null, $permission = null, $active = null)
    {
        $user = self::addQueryFilter($query, $keywords, $maxResults, $active)->all();
        return self::filterByPermission($user, $permission);
    }

    /**
     * @param ActiveQuery $query
     * @param null $keywords
     * @param null $maxResults
     * @param null $active
     * @return ActiveQuery
     */
    public static function addQueryFilter(ActiveQuery $query, $keywords = null, $maxResults = null, $active = null)
    {
        self::addKeywordFilter($query, $keywords);
        
        if ($maxResults != null) {
            $query->limit($maxResults);
        }

        if (($active != null && $active) || $active == null) {
            $query->active();
        }
        
        return $query;
    }

    /**
     * @param ActiveQuery $query
     * @param $keyword
     * @return ActiveQuery
     */
    public static function addKeywordFilter(ActiveQuery $query, $keyword)
    {
        $query->joinWith('profile');
        $parts = explode(" ", $keyword);
        foreach ($parts as $part) {
            $query->andFilterWhere(
                    ['or',
                        ['like', 'user.email', $part],
                        ['like', 'user.username', $part],
                        ['like', 'profile.firstname', $part],
                        ['like', 'profile.lastname', $part],
                    ]
            );
        }
        return $query;
    }

    /**
     * Возвращает подмножество данного массива, содержащего всех пользователей данного набора у
     * которых есть данное рахрешение.
     *
     * @param $users
     * @param $permission
     * @return array
     */
    public static function filterByPermission($users, $permission)
    {
        if ($permission === null) {
            return $users;
        }

        $result = [];

        foreach ($users as $user) {
            if ($user->getPermissionManager()->can($permission)) {
                $result[] = $user;
            }
        }

        return $result;
    }
}
