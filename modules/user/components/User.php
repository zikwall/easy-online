<?php

namespace zikwall\easyonline\modules\user\components;

use Yii;
use yii\authclient\ClientInterface;
use yii\db\Expression;
use zikwall\easyonline\modules\user\authclient\interfaces\AutoSyncUsers;
use zikwall\easyonline\modules\user\models\Password;
use zikwall\easyonline\modules\core\libs\BasePermission;
use zikwall\easyonline\modules\user\authclient\AuthClientHelpers;

class User extends \yii\web\User
{
    /**
     * @var ClientInterface[] the users authclients
     */
    private $_authClients = null;

    /**
     * @var PermissionManager
     */
    protected $permissionManager = null;

    public function isAdmin()
    {
        if ($this->isGuest) {
            return false;
        }
        return $this->getIdentity()->isSystemAdmin();
    }

    public function getLanguage()
    {
        if ($this->isGuest) {
            return '';
        }
        return $this->getIdentity()->language;
    }

    public function getTimeZone()
    {
        if ($this->isGuest) {
            return '';
        }
        return $this->getIdentity()->time_zone;
    }

    public function getGuid()
    {
        if ($this->isGuest) {
            return '';
        }
        return $this->getIdentity()->guid;
    }

    /**
     * Verifies global GroupPermissions of this User component.
     *
     * The following example checks if this User is granted the GroupPermission
     *
     * ```php
     * if (Yii::$app->user->can(MyGroupPermission::class) {
     *   // ...
     * }
     * ```
     *
     * @param string|string[]|BasePermission $permission
     * @see PermissionManager::can()
     * @return boolean
     * @since 1.2
     */

    public function can($permission, $params = [], $allowCaching = true)
    {
        return $this->getPermissionManager()->can($permission, $params, $allowCaching);
    }


    /**
     * @return PermissionManager instance with the related identity instance as permission subject.
     */
    public function getPermissionManager()
    {
        if ($this->permissionManager !== null) {
            return $this->permissionManager;
        }
        $this->permissionManager = new PermissionManager(['subject' => $this->getIdentity()]);
        return $this->permissionManager;
    }

    public function setCurrentAuthClient(ClientInterface $authClient)
    {
        Yii::$app->session->set('currentAuthClientId', $authClient->getId());
    }

    public function getCurrentAuthClient()
    {
        foreach ($this->getAuthClients() as $authClient) {
            if ($authClient->getId() == Yii::$app->session->get('currentAuthClientId')) {
                return $authClient;
            }
        }
        return null;
    }

    public function getAuthClients()
    {
        if ($this->_authClients === null) {
            $this->_authClients = AuthClientHelpers::getAuthClientsByUser($this->getIdentity());
        }
        return $this->_authClients;
    }

    /**
     * @inheritdoc
     */
    public function afterLogin($identity, $cookieBased, $duration)
    {
        $identity->updateAttributes(['last_login' => new Expression('NOW()')]);
        parent::afterLogin($identity, $cookieBased, $duration);
    }

    /**
     * Checks if the system configuration allows access for guests
     *
     * @return boolean is guest access enabled and allowed
     */
    public static function isGuestAccessEnabled()
    {
        return (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess'));
    }

    /**
     * Determines if this user is able to change the password.
     * @return boolean
     */
    public function canChangePassword()
    {
        foreach ($this->getAuthClients() as $authClient) {
            if ($authClient->className() == Password::class) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines if this user is able to change the email address.
     * @return boolean
     */
    public function canChangeEmail()
    {
        if (in_array('email', AuthClientHelpers::getSyncAttributesByUser($this->getIdentity()))) {
            return false;
        }

        return true;
    }

    /**
     * Determines if this user is able to delete his account.
     * @return boolean
     */
    public function canDeleteAccount()
    {
        foreach ($this->getAuthClients() as $authClient) {
            if ($authClient instanceof AutoSyncUsers) {
                return false;
            }
        }
        return true;
    }
}
