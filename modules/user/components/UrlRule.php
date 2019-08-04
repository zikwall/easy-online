<?php

namespace zikwall\easyonline\modules\user\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use zikwall\easyonline\modules\user\models\User as UserModel;

class UrlRule extends BaseObject implements UrlRuleInterface
{
    /**
     * @var array
     */
    protected static $userUrlMap = [];

    /**
     * @var string
     */
    public $defaultRoute = 'user/profile';

    /**
     * @inheritdoc
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

                $url = "@" . urlencode(strtolower($username)) . "/" . $route;
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

        if (substr($pathInfo, 0, 1) == "@") {
            $preParts = explode('@', $pathInfo, 2);
            $parts = explode('/', $preParts[1], 2);
            if (isset($parts[0])) {
                $user = UserModel::find()->where(['username' => $parts[0]])->one();
                if ($user !== null) {
                    if (!isset($parts[1]) || $parts[1] == "") {
                        $parts[1] = $this->defaultRoute;
                    }
                    $params = $request->get();
                    $params['uguid'] = $user->guid;

                    return [$parts[1], $params];
                }
            }
        }
        return false;
    }

    /**
     * @param $guid
     * @return mixed|null
     */
    public static function getUrlByUserGuid($guid)
    {
        if (isset(static::$userUrlMap[$guid])) {
            return static::$userUrlMap[$guid];
        }

        $user = UserModel::findOne(['guid' => $guid]);
        if ($user !== null) {
            static::$userUrlMap[$user->guid] = $user->username;
            return static::$userUrlMap[$user->guid];
        }

        return null;
    }

}
