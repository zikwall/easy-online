<?php

namespace zikwall\easyonline\modules\user\models;

use zikwall\easyonline\modules\core\libs\BasePermission;
use Yii;
use yii\helpers\Html;

class UserPicker
{
    public static function filter($cfg = null)
    {
        $defaultCfg = [
            'active' => true,
            'maxResult' => 10,
            'disableFillUser' => true,
            'keyword' => null,
            'permission' => null,
            'fillQuery' => null,
            'disabledText' => null,
            'fillUser' => false,
            'filter' => null
        ];
        
        $cfg = ($cfg == null) ? $defaultCfg : array_merge($defaultCfg, $cfg);
        
        if (!isset($cfg['query'])) {
            $cfg['query'] = (Yii::$app->getModule('friendship')->getIsEnabled()) 
                    ? Yii::$app->user->getIdentity()->getFriends()
                    : UserFilter::find();
        }
        
        $user = UserFilter::filter($cfg['query'], $cfg['keyword'], $cfg['maxResult'], null, $cfg['active']);
        $jsonResult = self::asJSON($user, $cfg['permission'], 2, $cfg['disabledText']);
        
        if (count($user) < $cfg['maxResult'] && (isset($cfg['fillQuery']) || $cfg['fillUser']) ) {
            
            $fillQuery = (isset($cfg['fillQuery'])) ? $cfg['fillQuery'] : UserFilter::find();
            UserFilter::addKeywordFilter($fillQuery, $cfg['keyword'], ($cfg['maxResult'] - count($user)));
            $fillQuery->andFilterWhere(['not in', 'id', self::getUserIdArray($user)]);
            $fillUser = $fillQuery->all();
            
            $disableCondition = (isset($cfg['permission'])) ? $cfg['permission']  : $cfg['disableFillUser'];
            $jsonResult = array_merge($jsonResult, self::asJSON($fillUser, $disableCondition, 1, $cfg['disabledText']));
        }   
        
        if ($cfg['filter'] != null) {
            array_walk($jsonResult, $cfg['filter']);
        }
        
        return $jsonResult;
    }

    /**
     * @param $users
     * @return array
     */
    private static function getUserIdArray($users)
    {
        $result = [];
        foreach($users as $user) {
            $result[] = $user->id;
        }
        return $result;
    }

    /**
     * @param $users
     * @param null $permission
     * @param null $priority
     * @param null $disabledText
     * @return array
     */
    public static function asJSON($users, $permission = null, $priority = null, $disabledText = null)
    {
        if (is_array($users)) {
            $result = [];
            foreach ($users as $user) {
                if ($user != null) {
                    $result[] = self::createJSONUserInfo($user, $permission, $priority, $disabledText);
                }
            }
            return $result;
        } else {
            return self::createJSONUserInfo($users, $permission, $priority, $disabledText);
        }
    }

    /**
     * @param User $user
     * @param null $permission
     * @param null $priority
     * @param null $disabledText
     * @return array
     */
    private static function createJSONUserInfo(User $user, $permission = null, $priority = null, $disabledText = null)
    {
        $disabled = false;
        
        if ($permission != null && $permission instanceof BasePermission) {
            $disabled = !$user->getPermissionManager()->can($permission);
        } else if ($permission != null) {
            $disabled = $permission;
        }

        return [
            'id' => $user->id,
            'guid' => $user->guid,
            'disabled' => $disabled,
            'disabledText' => ($disabled) ? $disabledText : null,
            'text' => Html::encode($user->displayName),
            'priority' => ($priority == null) ? 0 : $priority,
        ];
    }
}
