<?php

namespace zikwall\easyonline\modules\user\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\HttpException;
use zikwall\easyonline\modules\user\exceptions\ProfileForbidden;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\components\base\Controller;

class ProfileController extends Behavior
{
    /**
     * @var User
     */
    public $user = null;

    public static $subLayout = '@user/views/profile/_layout';

    public function events() {

        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function getUser()
    {
        if ($this->user != null) {
            return $this->user;
        }

        $guid = Yii::$app->request->getQuery('uguid');
        $this->user = User::findOne(['guid' => $guid]);

        if ($this->user == null)
            throw new HttpException(404, Yii::t('UserModule.behaviors_ProfileControllerBehavior', 'User not found!'));

        $this->checkAccess();

        return $this->user;
    }

    /**
     * @throws ProfileForbidden
     */
    public function checkAccess()
    {
        if (Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') && $this->user->visibility != User::VISIBILITY_ALL && Yii::$app->user->isGuest) {
            throw new ProfileForbidden(Yii::t('UserModule.behaviors_ProfileControllerBehavior', 'You need to login to view this user profile!'), $this->getUser());
        }
    }

    public function beforeAction($action)
    {
        $this->owner->prependPageTitle($this->user->displayName);
    }

}

?>
