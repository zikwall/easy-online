<?php

namespace zikwall\easyonline\modules\core\behaviors;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\user\models\User;

/**
 * AccessControl обеспечивает базовую защиту доступа к контроллеру
 *
 * Вот несколько примеров настроек контроля доступа:
 *
 * Разрешить гостевой доступ для действия «info»
 *
 * php```
 * [
 *      'acl' => [
 *          'class' => \core\components\behaviors\AccessControl::class,
 *          'guestAllowedActions' => ['info']
 *      ]
 * ]
 * ```
 *
 * Разрешить доступ по правилу разрешения:
 *
 * php```
 * [
 *      'acl' => [
 *          'class' => \core\components\behaviors\AccessControl::class,
 *          'rules' => [
 *              [
 *                  'groups' => [
 *                      'core\modules\xy\permissions\MyAccessPermssion'
 *                  ]
 *              ]
 *          ]
 *      ]
 * ]
 * ```
 */
class AccessControl extends \yii\base\ActionFilter
{

    /**
     * Идентификаторы действий, которые разрешены, когда включен гостевой режим
     *
     * @var []
     */
    public $guestAllowedActions = [];

    /**
     * Правила доступа к контроллеру
     *
     * @var []
     */
    public $rules = [];

    /**
     * Разрешать администратору доступ только к этому контроллеру
     *
     * @var boolean
     */
    public $adminOnly = false;

    /**
     * Разрешать доступ к этому контроллеру только для пользователей
     */
    public $loggedInOnly = true;

    public $_userGroupNames;

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        /**
         * @var $identity
         */
        $identity = Yii::$app->user->getIdentity();

        if ($identity != null && !$identity->isActive()) {
            return $this->handleInactiveUser();
        }

        if (Yii::$app->user->isGuest && !$this->adminOnly) {
            return $this->handleGuestAccess($action);
        }

        if ($this->adminOnly && !Yii::$app->user->isAdmin()){
            $this->forbidden();
        }

        if ($this->adminOnly && !Yii::$app->user->isAdmin()) {
            if ($this->getControllerGroup() == null || !$this->getControllerGroup()->isAdmin()) {
                $this->forbidden();
            }
        }

        if ($this->checkRules()) {
            return true;
        }

        return $this->loggedInOnly;
    }

    /**
     * Отключить доступ для неактивных пользователей, выполнив выход из системы.
     */
    protected function handleInactiveUser() : bool
    {
        Yii::$app->user->logout();
        Yii::$app->response->redirect(['/user/auth/login']);

        return false;
    }

    /**
     * Проверяет доступ для гостевых пользователей.
     *
     * Гости имеют доступ к действию, если в флагах $loggedInOnly и $adminOnly
     * установлено значение false или данное действие (action) контроллера содержится в $guestAllowedActions.
     */
    protected function handleGuestAccess($action) : bool
    {
        if (!$this->loggedInOnly && !$this->adminOnly) {
            return true;
        }

        if (in_array($action->id, $this->guestAllowedActions) && Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') == 1) {
            return true;
        }

        Yii::$app->user->loginRequired();

        return false;
    }

    /**
     * Проверяет правила группы пользователя и разрешения.
     */
    protected function checkRules() : bool
    {
        if (!empty($this->rules)) {
            foreach ($this->rules as $rule) {
                if ($this->checkGroupRule($rule) || $this->checkPermissionRule($rule)) {
                    return true;
                }
            }
            $this->forbidden();
        }

        return true;
    }

    /**
     * Проверяет правила разрешения.
     */
    protected function checkPermissionRule($rule) : bool
    {
        if (!empty($rule['permissions'])) {
            if (!$this->checkRuleAction($rule)) {
                return false;
            }

            $permissionArr = (!is_array($rule['permissions'])) ? [$rule['permissions']] : $rule['permissions'];
            $params = isset($rule['params']) ? $rule['params'] : [];

            return Yii::$app->user->can($permissionArr, $params);
        }

        return false;
    }

    /**
     * Проверяет текущее действие контроллера на действие разрешенного правила.
     * если правило не содержит никаких настроек действия, правило разрешено для всех действий контроллера.
     */
    private function checkRuleAction(array $rule) : bool
    {
        if (!empty($rule['actions'])) {
            $action = Yii::$app->controller->action->id;
            return in_array($action, $rule['actions']);
        }

        return true;
    }

    /**
     * Проверяет определенный доступ группы по именам групп.
     */
    protected function checkGroupRule($rule) : bool
    {
        if (!empty($rule['groups'])) {
            $userGroups = $this->getUserGroupNames();
            $isAllowedAction = $this->checkRuleAction($rule);
            $allowedGroups = array_map('strtolower', $rule['groups']);
            foreach ($allowedGroups as $allowedGroup) {
                if (in_array($allowedGroup, $userGroups) && $isAllowedAction) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function isContentContainerController() : bool
    {
        return $this->owner instanceof ContentContainerController;
    }

    private function getControllerGroup()
    {
        if ($this->isContentContainerController()) {
            return $this->owner->getGroup();
        }

        return null;
    }

    /**
     * Возвращает массив строк со всеми группами пользователей текущего пользователя.
     */
    private function getUserGroupNames() : array
    {
        if ($this->_userGroupNames == null) {
            /**
             * @var $identity User
             */
            $identity = Yii::$app->user->getIdentity();
            $this->_userGroupNames = ArrayHelper::getColumn(ArrayHelper::toArray($identity->groups), 'name');
            $this->_userGroupNames = array_map('strtolower', $this->_userGroupNames);
        }

        return $this->_userGroupNames;
    }

    /**
     * @throws ForbiddenHttpException
     */
    protected function forbidden()
    {
        throw new ForbiddenHttpException(Yii::t('error', 'You are not allowed to perform this action.'));
    }

}
