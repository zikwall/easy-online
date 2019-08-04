<?php

namespace zikwall\easyonline\modules\community\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use zikwall\easyonline\modules\community\models\Community;

class UrlRule extends BaseObject implements UrlRuleInterface
{
    /**
     * @var string
     */
    public $defaultRoute = 'community/community';

    /**
     * @var array
     */
    protected static $communityUrlMap = [];

    /**
     * @inheritdoc
     */
    public function createUrl($manager, $route, $params)
    {
        if (isset($params['sguid'])) {
            if ($route == $this->defaultRoute) {
                $route = '';
            }

            $urlPart = static::getUrlByCommunityGuid($params['sguid']);
            if ($urlPart !== null) {
                $url = "@" . urlencode($urlPart) . "/" . $route;
                unset($params['sguid']);

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
                $community = Community::find()->where(['guid' => $parts[0]])->orWhere(['url' => $parts[0]])->one();
                if ($community !== null) {
                    if (!isset($parts[1]) || $parts[1] == "") {
                        $parts[1] = $this->defaultRoute;
                    }

                    $params = $request->get();
                    $params['sguid'] = $community->guid;

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
    public static function getUrlByCommunityGuid($guid)
    {
        if (isset(static::$communityUrlMap[$guid])) {
            return static::$communityUrlMap[$guid];
        }

        $community = Community::findOne(['guid' => $guid]);
        if ($community !== null) {
            static::$communityUrlMap[$community->guid] = ($community->url != '') ? $community->url : $community->guid;
            return static::$communityUrlMap[$community->guid];
        }

        return null;
    }

}
