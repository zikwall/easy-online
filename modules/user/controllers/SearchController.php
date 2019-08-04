<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\web\Controller;
use zikwall\easyonline\modules\user\models\UserPicker;

/**
 * Search Controller provides action for searching users.
 */
class SearchController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \zikwall\easyonline\modules\core\behaviors\AccessControl::class,
            ]
        ];
    }

    /**
     * JSON Search for Users
     *
     * Returns an array of users with fields:
     *  - guid
     *  - displayName
     *  - image
     *  - profile link
     */
    public function actionJson()
    {
        Yii::$app->response->format = 'json';

        return UserPicker::filter([
            'keyword' => Yii::$app->request->get('keyword'),
            'fillUser' => true,
            'disableFillUser' => false
        ]);
    }

}

?>
