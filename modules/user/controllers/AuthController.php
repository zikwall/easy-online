<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\ui\widgets\ContentModalDialog;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\authclient\AuthAction;
use zikwall\easyonline\modules\user\models\Invite;
use zikwall\easyonline\modules\user\models\forms\Login;
use zikwall\easyonline\modules\user\authclient\AuthClientHelpers;
use zikwall\easyonline\modules\user\authclient\interfaces\ApprovalBypass;

class AuthController extends Controller
{
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'external' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        // Удалить authClient из сеанса - если он уже существует
        Yii::$app->session->remove('authClient');

        return parent::beforeAction($action);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionLanguages()
    {
        if (Yii::$app->request->isAjax) {
            return ContentModalDialog::widget([
                'content' => $this->renderAjax('languages', [
                    'languages' => Yii::$app->i18n->getAllowedLanguages()
                ]),
                'title' => 'Выберите Ваш язык'
            ]);
        }
    }

    /**
     * @return $this|string|void|Response
     * @throws \Exception
     */
    public function actionLogin()
    {
        // Если пользователь уже вошел в систему, перенаправляйте Url::home
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        // Обработка формы входа в систему
        $login = new Login;
        if ($login->load(Yii::$app->request->post()) && $login->validate()) {
            return $this->onAuthSuccess($login->authClient);
        }

        // Приглашение
        $invite = new Invite();
        $invite->scenario = 'invite';
        if ($invite->load(Yii::$app->request->post()) && $invite->selfInvite()) {
            // ToDo
            if ($redicrect = true) {
                return $this->redirect(['/user/registration', 'token' => $invite->token]);
            } else {
                if (Yii::$app->request->isAjax) {
                    return $this->renderAjax('register_success_modal', ['model' => $invite]);
                } else {
                    return $this->render('register_success', ['model' => $invite]);
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            return ContentModalDialog::widget([
                'content' => $this->renderAjax('login_modal', [
                    'model' => $login,
                    'invite' => $invite,
                    'canRegister' => $invite->allowSelfInvite()
                ]),
                'title' => Yii::t('UserModule.views_auth_login', '<strong>Join</strong> the network')
            ]);
        }

        return $this->render('login',[
            'model' => $login,
            'invite' => $invite,
            'canRegister' => $invite->allowSelfInvite()
        ]);
    }

    /**
     * Метод обрабатывает успешную аутентификацию
     */
    public function onAuthSuccess(\yii\authclient\BaseClient $authClient)
    {
        $attributes = $authClient->getUserAttributes();

        // Пользователь уже вошел в систему - добавляет новый authclient к существующему пользователю
        if (!Yii::$app->user->isGuest) {
            AuthClientHelpers::storeAuthClientForUser($authClient, Yii::$app->user->getIdentity());
            return $this->redirect(['/user/account/connected-accounts']);
        }

        // Вход существующего пользователя
        $user = AuthClientHelpers::getUserByAuthClient($authClient);

        if ($user !== null) {
            return $this->login($user, $authClient);
        }

        if (!$authClient instanceof ApprovalBypass && !Yii::$app->getModule('user')->settings->get('auth.anonymousRegistration')) {
            Yii::$app->session->setFlash('error', Yii::t('UserModule.base', "You're not registered."));
            return $this->redirect(['/user/auth/login']);
        }

        // Проверяем, указан ли E-Mail
        if (!isset($attributes['email'])) {
            Yii::$app->session->setFlash('error', Yii::t(
                'UserModule.base',
                'Missing E-Mail Attribute from AuthClient.'
            ));
            return $this->redirect(['/user/auth/login']);
        }

        if (!isset($attributes['id'])) {
            Yii::$app->session->setFlash('error', Yii::t(
                'UserModule.base',
                'Missing ID AuthClient Attribute from AuthClient.'
            ));
            return $this->redirect(['/user/auth/login']);
        }

        // Проверяем, действительно ли отправлено письмо
        if (User::findOne(['email' => $attributes['email']]) !== null) {
            Yii::$app->session->setFlash('error', Yii::t('UserModule.base', 'User with the same email already exists but isn\'t linked to you. Login using your email first to link it.'));
            return $this->redirect(['/user/auth/login']);
        }

        // Попробуйте автоматически создать пользователя и пользователя входа
        $user = AuthClientHelpers::createUser($authClient);
        if ($user !== null) {
            return $this->login($user, $authClient);
        }

        // Нормализовали атрибуты пользователя перед тем, как поместить его в сеанс (анонимные функции)
        $authClient->setNormalizeUserAttributeMap([]);

        // Хранить authclient в сеансе - для контроллера регистрации
        Yii::$app->session->set('authClient', $authClient);

        // Запуск процесса регистрации
        return $this->redirect(['/user/registration']);
    }

    protected function login(User $user, \yii\authclient\BaseClient $authClient)
    {
        $redirectUrl = ['/user/auth/login'];
        if ($user->status == User::STATUS_ENABLED) {
            $duration = 0;
            if ($authClient instanceof \zikwall\easyonline\modules\user\authclient\BaseFormAuth) {
                if ($authClient->login->rememberMe) {
                    $duration = Yii::$app->getModule('user')->loginRememberMeDuration;
                }
            }

            AuthClientHelpers::updateUser($authClient, $user);

            if (Yii::$app->user->login($user, $duration)) {
                Yii::$app->user->setCurrentAuthClient($authClient);
                $redirectUrl = Yii::$app->user->returnUrl;
            }
        } elseif ($user->status == User::STATUS_DISABLED) {
            Yii::$app->session->setFlash('error', Yii::t('UserModule.base', 'Your account is disabled!'));
        } elseif ($user->status == User::STATUS_NEED_APPROVAL) {
            Yii::$app->session->setFlash('error', Yii::t('UserModule.base', 'Your account is not approved yet!'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('UserModule.base', 'Unknown user status!'));
        }

        if (Yii::$app->request->getIsAjax()) {
            return $this->htmlRedirect($redirectUrl);
        }

        return $this->redirect($redirectUrl);
    }

    public function actionLogout()
    {
        $language = Yii::$app->user->language;

        Yii::$app->user->logout();

        // Сохранение пользовательского языка в сеансе
        if ($language != "") {
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $language,
                'expire' => time() + 86400 * 365,
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);
        }

        return $this->redirect(($this->module->logoutUrl) ? $this->module->logoutUrl : Yii::$app->homeUrl);
    }

    /**
     * Позволяет сторонним приложениям конвертировать действительный sessionId в имя пользователя.
     */
    public function actionGetSessionUserJson()
    {
        Yii::$app->response->format = 'json';

        $sessionId = Yii::$app->request->get('sessionId');

        $output = [];
        $output['valid'] = false;
        $httpSession = \zikwall\easyonline\modules\user\models\Session::findOne(['id' => $sessionId]);
        if ($httpSession != null && $httpSession->user != null) {
            $output['valid'] = true;
            $output['userName'] = $httpSession->user->username;
            $output['fullName'] = $httpSession->user->displayName;
            $output['email'] = $httpSession->user->email;
            $output['superadmin'] = $httpSession->user->isSystemAdmin();
        }
        return $output;
    }

}

?>
