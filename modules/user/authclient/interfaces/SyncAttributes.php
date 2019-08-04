<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2015 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient\interfaces;

/**
 * SyncAttributes interface allows the possiblitz to specify user attributes which will be automatically 
 * updated on login or by daily cronjob if AutoSyncUsers is enabled.
 * 
 * These attributes are also not writable by user.
 * 
 * @since 1.1
 * @author luke
 */
interface SyncAttributes
{

    /**
     * Returns attribute names which should be synced on login
     * 
     * @return array attribute names to be synced
     */
    public function getSyncAttributes();
}
