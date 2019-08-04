<?php
namespace zikwall\easyonline\modules\core\components\extended;

use Yii;
use zikwall\easyonline\modules\core\components\base\Controller;

class FrontendController extends Controller
{
    public function beforeAction($action)
    {
        /**
         * ToDo: create frontend and backend aplication like the yii advanced app
         */

        /*
         * $theme = Yii::$app->getView()->theme;
         * Yii::$app->getView()->theme = new \yii\base\Theme([
            'pathMap' => [
                '@app/views' => '@zikwall/easyonline/themes/' . $theme->name . '/views',
            ],
            'baseUrl' => '@web/themes/' . $theme->name,
            'basePath' => '@zikwall/themes/'. $theme->name,
        ]);
        */

        return parent::beforeAction($action);
    }
}
