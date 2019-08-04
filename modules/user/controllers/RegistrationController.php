<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\authclient\ClientInterface;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\Invite;
use zikwall\easyonline\modules\user\models\forms\Registration;
use zikwall\easyonline\modules\user\authclient\interfaces\ApprovalBypass;

class RegistrationController extends Controller
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            throw new HttpException(401, 'Your are already logged in! - Logout first!');
        }

        return parent::beforeAction($action);
    }

    /**
     * @param $token
     * @return $this|string|void|\yii\web\Response
     * @throws Exception
     * @throws HttpException
     */
    public function actionIndex($token)
    {
        $registration = new Registration();

        /**
         * @var \yii\authclient\BaseClient
         */
        $authClient = null;
        $inviteToken = !empty($token) ? $token :  Yii::$app->request->get('token', '');

        if ($inviteToken != '') {
            $this->handleInviteRegistration($inviteToken, $registration);
        } elseif (Yii::$app->session->has('authClient')) {
            $authClient = Yii::$app->session->get('authClient');
            $this->handleAuthClientRegistration($authClient, $registration);
        } else {
            Yii::$app->session->setFlash('error', 'Registration failed.');
            return $this->redirect(['/user/auth/login']);
        }

        if ($registration->submitted('save') && $registration->validate() && $registration->register($authClient)) {
            Yii::$app->session->remove('authClient');

            // Autologin when user is enabled (no approval required)
            if ($registration->getUser()->status === User::STATUS_ENABLED) {
                Yii::$app->user->switchIdentity($registration->models['User']);
                $registration->models['User']->updateAttributes(['last_login' => new \yii\db\Expression('NOW()')]);
                return $this->redirect([Url::home()]);
            }

            return $this->render('success', [
                'form' => $registration,
                'needApproval' => ($registration->getUser()->status === User::STATUS_NEED_APPROVAL)
            ]);
        }

        return $this->render('index', ['hForm' => $registration]);
    }

    /**
     * @param $inviteToken
     * @param Registration $form
     * @throws HttpException
     */
    protected function handleInviteRegistration($inviteToken, Registration $form)
    {
        $userInvite = Invite::findOne(['token' => $inviteToken]);
        if (!$userInvite) {
            throw new HttpException(404, 'Invalid registration token!');
        }
        if ($userInvite->language) {
            Yii::$app->language = $userInvite->language;
        }
        $form->getUser()->email = $userInvite->email;
    }

    /**
     * @param ClientInterface $authClient
     * @param Registration $registration
     * @throws Exception
     */
    protected function handleAuthClientRegistration(ClientInterface $authClient, Registration $registration)
    {
        $attributes = $authClient->getUserAttributes();

        if (!isset($attributes['id'])) {
            throw new Exception("No user id given by authclient!");
        }

        $registration->enablePasswordForm = false;
        if ($authClient instanceof ApprovalBypass) {
            $registration->enableUserApproval = false;
        }

        // do not store id attribute
        unset($attributes['id']);

        $registration->getUser()->setAttributes($attributes, false);
        $registration->getProfile()->setAttributes($attributes, false);
    }
}
