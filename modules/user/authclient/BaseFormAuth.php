<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2016 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient;

use yii\base\NotSupportedException;
use zikwall\easyonline\modules\user\models\forms\Login;

/**
 * BaseFormAuth is a base class for AuthClients using the Login Form
 *
 * @since 1.1
 */
class BaseFormAuth extends BaseClient
{

    /**
     * @var Login the login form model
     */
    public $login = null;

    /**
     * Authenticate the user using the login form.
     *
     * @throws NotSupportedException
     */
    public function auth()
    {
        throw new NotSupportedException('Method "' . get_class($this) . '::' . __FUNCTION__ . '" not implemented.');
    }

}
