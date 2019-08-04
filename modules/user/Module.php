<?php

namespace zikwall\easyonline\modules\user;

use zikwall\easyonline\modules\gym\models\Gym;
use zikwall\easyonline\modules\user\models\User;
use Yii;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    public $controllerNamespace = 'zikwall\easyonline\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public $customViews = [];

    /**
     * @inheritdoc
     */
    public $customMailViews = [];

    /**
     * @var boolean option to translate all invite mails except self invites to the default language (true) or user language (false)
     */
    public $sendInviteMailsInGlobalLanguage = true;

    /**
     * @var boolean default state of remember me checkbox on login page
     */
    public $loginRememberMeDefault = true;

    /**
     * @var int number of seconds that the user can remain in logged-in status if remember me is clicked on login
     */
    public $loginRememberMeDuration = 2592000;

    /**
     * @var string redirect url after logout (if not set, home url will be used)
     */
    public $logoutUrl = null;

    /**
     * @var string the default route for user profiles
     */
    public $profileDefaultRoute = null;

    /**
     * @var int the default pagination size of the user list lightbox
     * @see widgets\UserListBox
     */
    public $userListPaginationSize = 8;

    /**
     * @var callable a callback that returns the user displayName
     */
    public $displayNameCallback = null;

    /**
     * @var int minimum username length
     */
    public $minimumUsernameLength = 4;

    /**
     * @var boolean defines if the user following is disabled or not.
     */
    public $disableFollow = false;

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        return [
            new permissions\ManageUsers(),
            new permissions\ManageGroups(),
        ];
    }

    public function getCustomView($default)
    {
        if (isset($this->customViews[$default])) {
            return $this->customViews[$default];
        } else {
            return $default;
        }
    }

    public function getCustomMailView($default)
    {
        if (isset($this->customMailViews[$default])) {
            return $this->customMailViews[$default];
        } else {
            return '@app/modules/user/mail/' . $default;
        }
    }
}
