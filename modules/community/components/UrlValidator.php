<?php

namespace zikwall\easyonline\modules\community\components;

use Yii;
use yii\validators\Validator;
use URLify;
use zikwall\easyonline\modules\community\models\Community;

class UrlValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (mb_strtolower($value) != URLify::filter($value, 45)) {
            $this->addError($model, $attribute, Yii::t('CommunityModule.manage', 'The url contains illegal characters!'));
        }
    }

    /**
     * @param $name
     * @return string
     */
    public static function autogenerateUniqueCommunityUrl($name)
    {
        $maxUrlLength = 45;

        $url = URLify::filter($name, $maxUrlLength - 4);

        $existingCommunityUrls = [];
        foreach (Community::find()->where(['LIKE', 'url', $url . '%', false])->all() as $community) {
            $existingCommunityUrls[] = $community->url;
        }

        if (!in_array($url, $existingCommunityUrls)) {
            return $url;
        }

        for ($i = 0, $existingCommunityUrlsCount = count($existingCommunityUrls); $i <= $existingCommunityUrlsCount; $i++) {
            $tryUrl = $url . ($i + 2);
            if (!in_array($tryUrl, $existingCommunityUrls)) {
                return $tryUrl;
            }
        }

        return "";
    }

}
