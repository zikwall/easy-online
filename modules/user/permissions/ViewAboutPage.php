<?php

namespace zikwall\easyonline\modules\user\permissions;

use Yii;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\libs\BasePermission;

/**
 * ViewAboutPage Permission
 */
class ViewAboutPage extends BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        User::USERGROUP_SELF
    ];

    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->title = \Yii::t('UserModule.permissions', 'View your about page');
        $this->description = \Yii::t('UserModule.permissions', 'Allows access to your about page with personal information');
    }

    /**
     * @inheritdoc
     */
    public function getDefaultState($groupId)
    {
        // When friendship is disabled, also allow normal members to see about page
        if ($groupId == User::USERGROUP_USER && !Yii::$app->getModule('friendship')->getIsEnabled()) {
            return self::STATE_ALLOW;
        }

        return parent::getDefaultState($groupId);
    }

    /**
     * @inheritdoc
     */
    protected $title;

    /**
     * @inheritdoc
     */
    protected $description;

    /**
     * @inheritdoc
     */
    protected $moduleId = 'user';

}
