<?php

namespace zikwall\easyonline\modules\user\controllers;

use yii\web\HttpException;
use zikwall\easyonline\modules\core\components\compatibility\HForm;
use zikwall\easyonline\modules\user\authclient\AuthClientHelpers;
use zikwall\easyonline\modules\user\authclient\BaseFormAuth;
use zikwall\easyonline\modules\user\authclient\interfaces\PrimaryClient;
use zikwall\easyonline\modules\user\components\BaseAccountController;
use Yii;
use zikwall\easyonline\modules\user\models\forms\AccountChangeEmail;
use zikwall\easyonline\modules\user\models\forms\AccountDelete;
use zikwall\easyonline\modules\user\models\forms\AccountSettings;
use zikwall\easyonline\modules\user\models\Password;
use zikwall\easyonline\modules\user\models\User;

class AccountController extends BaseAccountController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('account', []);
    }

    public function actionEdit()
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();
        $user->profile->scenario = 'editProfile';

        // Get Form Definition
        $definition = $user->profile->getFormDefinition();
        $definition['buttons'] = [
            'save' => [
                'type' => 'submit',
                'label' => Yii::t('UserModule.controllers_AccountController', 'Save profile'),
                'class' => 'btn btn-primary'
            ],
        ];

        $form = new HForm($definition, $user->profile);
        $form->showErrorSummary = true;
        if ($form->submitted('save') && $form->validate() && $form->save()) {

            // Trigger search refresh
            $user->save();

            $this->view->saved();
            return $this->redirect(['edit']);
        }

        return $this->render('edit', ['hForm' => $form]);
    }

    public function actionEditModules()
    {
        /**
         * @var $user
         */
        $user = Yii::$app->user->getIdentity();
        $availableModules = $user->getAvailableModules();

        return $this->render('editModules', [
            'user' => $user,
            'availableModules' => $availableModules
        ]);
    }

    public function actionEnableModule()
    {
        /**
         * ToDo: enable _csrf validating
         */
        $this->enableCsrfValidation = false;

        $this->forcePostRequest();

        /**
         * @var $user User
         */
        $user = Yii::$app->user->getIdentity();
        $moduleId = Yii::$app->request->get('moduleId');

        if (!$user->isModuleEnabled($moduleId)) {
            $user->enableModule($moduleId);
        }

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['/user/account/edit-modules']);
        } else {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }
    }

    public function actionDisableModule()
    {
        $this->enableCsrfValidation = false;

        $this->forcePostRequest();

        /**
         * @var $user User
         */
        $user = Yii::$app->user->getIdentity();
        $moduleId = Yii::$app->request->get('moduleId');

        if ($user->isModuleEnabled($moduleId) && $user->canDisableModule($moduleId)) {
            $user->disableModule($moduleId);
        }

        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['/user/account/edit-modules']);
        } else {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }
    }

    public function actionEditSettings()
    {
        /**
         * @var $user User
         */
        $user = $this->getUser();

        $model = new AccountSettings();
        $model->language = $user->language;
        if ($model->language == "") {
            $model->language = Yii::$app->settings->get('defaultLanguage');
        }
        $model->timeZone = $user->time_zone;
        if ($model->timeZone == "") {
            $model->timeZone = Yii::$app->settings->get('timeZone');
        }

        $model->tags = $user->tags;
        $model->visibility = $user->visibility;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->language = $model->language;
            $user->tags = $model->tags;
            $user->time_zone = $model->timeZone;
            $user->visibility = $model->visibility;
            $user->save();
            $this->view->saved();
            return $this->redirect(['edit-settings']);
        }

        // Сортировка списка стран на основе языка пользователя
        $languages = Yii::$app->i18n->getAllowedLanguages();
        $col = new \Collator(Yii::$app->language);
        $col->asort($languages);

        return $this->render('editSettings', ['model' => $model, 'languages' => $languages]);
    }

    public function actionSecurity()
    {
        $groups = [];
        $groupAccessEnabled = (boolean) Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess');

        if (Yii::$app->getModule('friendship')->getIsEnabled()) {
            $groups[User::USERGROUP_FRIEND] = Yii::t('UserModule.account', 'Your friends');
            $groups[User::USERGROUP_USER] = Yii::t('UserModule.account', 'Other users');
        } else {
            $groups[User::USERGROUP_USER] = Yii::t('UserModule.account', 'Users');
        }

        if ($groupAccessEnabled) {
            $groups[User::USERGROUP_GUEST] = Yii::t('UserModule.account', 'Not registered users');
        }

        $currentGroup = Yii::$app->request->get('groupId');
        if ($currentGroup == '' || !isset($groups[$currentGroup])) {
            $currentGroup = User::USERGROUP_USER;
        }

        // Изменение состояния разрешения доступа
        if (Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $permission = $this->getUser()->permissionManager->getById(Yii::$app->request->post('permissionId'), Yii::$app->request->post('moduleId'));
            if ($permission === null) {
                throw new HttpException(500, 'Could not find permission!');
            }
            $this->getUser()->permissionManager->setGroupState($currentGroup, $permission, Yii::$app->request->post('state'));
            return [];
        }

        return $this->render('security', ['user' => $this->getUser(), 'groups' => $groups, 'group' => $currentGroup, 'multipleGroups' => (count($groups) > 1)]);
    }

    public function actionConnectedAccounts()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->get('disconnect')) {
            foreach (Yii::$app->user->getAuthClients() as $authClient) {
                /**
                 * @var $authClient BaseFormAuth
                 */
                if ($authClient->getId() == Yii::$app->request->get('disconnect')) {
                    AuthClientHelpers::removeAuthClientForUser($authClient, Yii::$app->user->getIdentity());
                }
            }
            return $this->redirect(['connected-accounts']);
        }
        $clients = [];
        foreach (Yii::$app->get('authClientCollection')->getClients() as $client) {
            if (!$client instanceof BaseFormAuth && !$client instanceof PrimaryClient) {
                $clients[] = $client;
            }
        }

        $currentAuthProviderId = "";
        if (Yii::$app->user->getCurrentAuthClient() !== null) {
            $currentAuthProviderId = Yii::$app->user->getCurrentAuthClient()->getId();
        }

        $activeAuthClientIds = [];
        foreach (Yii::$app->user->getAuthClients() as $authClient) {
            $activeAuthClientIds[] = $authClient->getId();
        }

        return $this->render('connected-accounts', [
            'authClients' => $clients,
            'currentAuthProviderId' => $currentAuthProviderId,
            'activeAuthClientIds' => $activeAuthClientIds
        ]);
    }

    public function actionChangeEmail()
    {
        if (!Yii::$app->user->canChangeEmail()) {
            throw new HttpException(500, 'Change E-Mail is not allowed');
        }

        $model = new AccountChangeEmail();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->sendChangeEmail()) {
            return $this->render('changeEmail_success', array('model' => $model));
        }

        return $this->render('changeEmail', array('model' => $model));
    }

    public function actionChangeEmailValidate()
    {
        if (!Yii::$app->user->canChangeEmail()) {
            throw new HttpException(500, 'Change E-Mail is not allowed');
        }

        $token = Yii::$app->request->get('token');
        $email = Yii::$app->request->get('email');

        $user = Yii::$app->user->getIdentity();

        // Check if Token is valid
        if (md5(Yii::$app->settings->get('secret') . $user->guid . $email) != $token) {
            throw new HttpException(404, Yii::t('UserModule.controllers_AccountController', 'Invalid link! Please make sure that you entered the entire url.'));
        }

        // Check if E-Mail is in use, e.g. by other user
        $emailAvailablyCheck = User::findOne(['email' => $email]);
        if ($emailAvailablyCheck != null) {
            throw new HttpException(404, Yii::t('UserModule.controllers_AccountController', 'The entered e-mail address is already in use by another user.'));
        }

        $user->email = $email;
        $user->save();

        return $this->render('changeEmailValidate', ['newEmail' => $email]);
    }

    /**
     * Change users current password
     */
    public function actionChangePassword()
    {
        if (!Yii::$app->user->canChangePassword()) {
            throw new HttpException(500, 'Password change is not allowed');
        }

        $userPassword = new Password();
        $userPassword->scenario = 'changePassword';

        if ($userPassword->load(Yii::$app->request->post()) && $userPassword->validate()) {
            $userPassword->user_id = Yii::$app->user->id;
            $userPassword->setPassword($userPassword->newPassword);
            $userPassword->save();

            return $this->render('changePassword_success');
        }

        return $this->render('changePassword', ['model' => $userPassword]);
    }

    public function actionDelete()
    {
        $isSpaceOwner = false;
        $user = Yii::$app->user->getIdentity();

        if (!Yii::$app->user->canDeleteAccount()) {
            throw new HttpException(500, 'Account deletion not allowed');
        }

        $model = new AccountDelete();

        if (!$isSpaceOwner && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->delete();
            Yii::$app->user->logout();
            return $this->goHome();
        }

        return $this->render('delete',[
            'model' => $model,
            'isSpaceOwner' => $isSpaceOwner
        ]);
    }

    /**
     * @return null|\yii\web\IdentityInterface|static
     * @throws HttpException
     */
    public function getUser()
    {
        if (Yii::$app->request->get('userGuid') != '' && Yii::$app->user->getIdentity()->isSystemAdmin()) {
            $user = User::findOne(['guid' => Yii::$app->request->get('userGuid')]);
            if ($user === null) {
                throw new HttpException(404, 'Could not find user!');
            }
            return $user;
        }

        return Yii::$app->user->getIdentity();
    }
}

