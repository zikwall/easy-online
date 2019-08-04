<?php
namespace zikwall\easyonline\modules\user\exceptions;

use yii\web\UnauthorizedHttpException;
use zikwall\easyonline\modules\user\models\User;

class ProfileForbidden extends UnauthorizedHttpException
{
    /**
     * @var User
     */
    public $user;

    /**
     * ProfileForbidden constructor.
     * @param null $message
     * @param User $user
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, User $user, $code = 0, \Exception $previous = null)
    {
        $this->user = $user;

        parent::__construct($message, $code, $previous);
    }
}
