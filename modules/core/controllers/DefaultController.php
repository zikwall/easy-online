<?php

namespace zikwall\easyonline\modules\core\controllers;

use zikwall\easyonline\modules\core\components\extended\FrontendController;
use Yii;

class DefaultController extends FrontendController
{
    public function init()
    {
        $this->appendPageTitle('Home');
        parent::init();
    }

    public function actionHome()
    {
        if (Yii:: $app->user->getIsGuest()) {
            $this->redirect(['/user/auth/login']);
        }

        return $this->render('home');
    }

    public function actionTerms()
    {
        $this->appendPageTitle('Terms');
        return $this->render('terms');
    }
}
