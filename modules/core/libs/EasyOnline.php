<?php

namespace zikwall\easyonline\modules\core\libs;

use Yii;
use yii\helpers\Json;
use zikwall\easyonline\modules\core\libs\CURLHelper;

class EasyOnline
{
    public static function request($action, $params = [])
    {
        if (!Yii::$app->params['easyonline']['apiEnabled']) {
            return [];
        }

        $url = Yii::$app->params['easyonline']['apiUrl'] . '/' . $action;
        $params['version'] = urlencode(Yii::$app->version);
        $params['installId'] = Yii::$app->getModule('admin')->settings->get('installationId');

        $url .= '?';
        foreach ($params as $name => $value) {
            $url .= urlencode($name) . '=' . urlencode($value)."&";
        }
        try {
            $http = new \Zend\Http\Client($url, [
                'adapter' => '\Zend\Http\Client\Adapter\Curl',
                'curloptions' => CURLHelper::getOptions(),
                'timeout' => 30
            ]);

            $response = $http->send();
            $json = $response->getBody();
        } catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $ex) {
            Yii::error('Could not connect to HumHub API! ' . $ex->getMessage());
            return [];
        } catch (Exception $ex) {
            Yii::error('Could not get HumHub API response! ' . $ex->getMessage());
            return [];
        }

        try {
            return Json::decode($json);
        } catch (\yii\base\InvalidArgumentException $ex) {
            Yii::error('Could not parse HumHub API response! ' . $ex->getMessage());
            return [];
        }
    }
    
    public static function getLatestEasyOnlineVersion()
    {
        $latestVersion = Yii::$app->cache->get('latestVersion');
        if ($latestVersion === false) {
            $info = self::request('v1/modules/getLatestVersion');

            if (isset($info['latestVersion'])) {
                $latestVersion = $info['latestVersion'];
            }

            Yii::$app->cache->set('latestVersion', $latestVersion);
        }

        return $latestVersion;
    }

}
