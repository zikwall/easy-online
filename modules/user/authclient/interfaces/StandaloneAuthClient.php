<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2016 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient\interfaces;

use zikwall\easyonline\modules\user\authclient\AuthAction;

/**
 * StandaloneAuthClient allows implementation of custom authclients
 * which not relies on auth handling by AuthAction
 *
 * @see \yii\authclient\AuthAction
 * @since 1.1.2
 * @author Luke
 */
interface StandaloneAuthClient
{

    /**
     * Custom auth action implementation
     *
     * @param AuthAction $authAction
     * @return Response response instance.
     */
    public function authAction($authAction);
}
