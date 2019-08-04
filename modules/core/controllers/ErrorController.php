<?php

namespace zikwall\easyonline\modules\core\controllers;

use Yii;
use yii\web\HttpException;
use yii\base\UserException;
use zikwall\easyonline\modules\core\components\extended\FrontendController;
use zikwall\easyonline\modules\user\exceptions\ProfileForbidden;

class ErrorController extends FrontendController
{
    //public $layout = '@easyonline/themes/core/views/layouts/error';

    /**
     * This is the action to handle external exceptions.
     */
    public function actionIndex()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof UserException || $exception instanceof HttpException) {
            $message = $exception->getMessage();
        } else {
            $message = Yii::t('error', 'An internal server error occurred.');
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return [
                'error' => true,
                'message' => $message
            ];
        }

        if ($exception instanceof ProfileForbidden) {
            if ($exception->statusCode == 401) {
                return $this->render('@user/views/error/profileForbidden', [
                    'message' => $message,
                    'user' => $exception->user
                ]);
            }
        }

        /**
         * Показать специальный вход для гостей
         */
        if (Yii::$app->user->isGuest && $exception instanceof HttpException && $exception->statusCode == "401" && Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess')) {
            return $this->render('401_guests', ['message' => $message]);
        }

        return $this->render('index', [
            'message' => $message
        ]);
    }

}
