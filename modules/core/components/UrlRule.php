<?php

namespace zikwall\easyonline\modules\core\components;

use yii\web\UrlRuleInterface;
use yii\base\Object;
use zikwall\easyonline\modules\user\models\User;

class UrlRule extends Object implements UrlRuleInterface
{
    /**
     * @var array кеш-карта с парами пользователей
     */
    protected static $userUrlMap = [];

    /**
     * @var string default route <module:user>/<controller:profile>
     */
    public $defaultRoute = 'user/profile';

    /**
     * @inheritdoc
     *
     * @return string user URL
     *      Format: /u/userName/<module>/<controller>/<action>
     *          -- /u - is user module/profile container
     */
    public function createUrl($manager, $route, $params)
    {
        if (isset($params['uguid'])) {
            $username = static::getUrlByUserGuid($params['uguid']);
            if ($username !== null) {
                unset($params['uguid']);

                if ($this->defaultRoute == $route) {
                    $route = "";
                }

                $url = "u/" . urlencode(strtolower($username)) . "/" . $route;
                if (!empty($params) && ($query = http_build_query($params)) !== '') {
                    $url .= '?' . $query;
                }
                return $url;
            }
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (substr($pathInfo, 0, 2) == "u/") {
            $parts = explode('/', $pathInfo, 3);
            if (isset($parts[1])) {
                $user = User::find()->where(['username' => $parts[1]])->one();
                if ($user !== null) {
                    if (!isset($parts[2]) || $parts[2] == "") {
                        $parts[2] = $this->defaultRoute;
                    }
                    $params = $request->get();
                    $params['uguid'] = $user->guid;

                    return [$parts[2], $params];
                }
            }
        }
        return false;
    }

    /**
     * @param string $guid
     * @return string|null the username
     */
    public static function getUrlByUserGuid(string $guid)
    {
        if (isset(static::$userUrlMap[$guid])) {
            return static::$userUrlMap[$guid];
        }

        $user = User::findOne(['guid' => $guid]);
        if ($user !== null) {
            static::$userUrlMap[$user->guid] = $user->username;
            return static::$userUrlMap[$user->guid];
        }

        return null;
    }

}
