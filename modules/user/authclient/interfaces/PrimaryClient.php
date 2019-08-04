<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2015 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient\interfaces;

/**
 * PrimaryClient authclient interface
 *
 * It's not possible to have to primary auth clients at the same time.
 * E.g. LDAP and Password
 *
 * @author luke
 */
interface PrimaryClient
{

    /**
     * Returns the user model attribute name which should be mapped against
     * the id attribute in the authClient user attributes.
     *
     * @return string the user model id attribute e.g. id, guid or email
     */
    public function getUserTableIdAttribute();
}
