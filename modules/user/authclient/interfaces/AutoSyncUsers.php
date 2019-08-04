<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2015 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient\interfaces;

/**
 * AutoSyncUsers interface adds the possiblity to automatically update/create users via AuthClient.
 * If this interface is implemented the cron will hourly execute the authclient's 
 * syncronization method.
 * 
 * @author luke
 */
interface AutoSyncUsers
{

    public function syncUsers();
}
