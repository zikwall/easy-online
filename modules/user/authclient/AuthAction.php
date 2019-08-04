<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2016 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\authclient;

use zikwall\easyonline\modules\user\authclient\interfaces\StandaloneAuthClient;

/**
 * Extended version of AuthAction with AuthClient support which are not handled
 * by AuthAction directly
 *
 * @sicne 1.1.2
 * @author Luke
 */
class AuthAction extends \yii\authclient\AuthAction
{

    /**
     * @inheritdoc
     * 
     * @param StandaloneAuthClient $client
     * @return response
     */
    public function auth($client)
    {
        if ($client instanceof StandaloneAuthClient) {
            return $client->authAction($this);
        }

        return parent::auth($client);
    }

    /**
     * @inheritdoc
     */
    public function authSuccess($client)
    {
        return parent::authSuccess($client);
    }

}
