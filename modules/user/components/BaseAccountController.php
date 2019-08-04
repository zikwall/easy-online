<?php

namespace zikwall\easyonline\modules\user\components;

use Yii;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\core\behaviors\AccessControl;

class BaseAccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public $subLayout = "@zikwall/easyonline/modules/user/views/account/_layout";

    /**
     * @var User the user
     */
    public $user;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->appendPageTitle(\Yii::t('UserModule.base', 'My Account'));
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::className(),
            ]
        ];
    }

    /**
     * Returns the current user of this account
     *
     * @return User
     */
    public function getUser()
    {
        if ($this->user === null) {
            $this->user = Yii::$app->user->getIdentity();
        }

        return $this->user;
    }

}
