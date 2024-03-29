<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2016 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient;

/**
 * Extended BaseClient with additional events
 *
 * @since 1.1
 * @author luke
 */
class BaseClient extends \yii\authclient\BaseClient
{

    /**
     * @event Event an event raised on update user data.
     * @see AuthClientHelpers::updateUser()
     */
    const EVENT_UPDATE_USER = 'update';

    /**
     * @event Event an event raised on create user.
     * @see AuthClientHelpers::createUser()
     */
    const EVENT_CREATE_USER = 'create';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        
    }

}
