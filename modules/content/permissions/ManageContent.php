<?php

namespace zikwall\easyonline\modules\content\permissions;

use zikwall\easyonline\modules\core\libs\BasePermission;
use zikwall\easyonline\modules\user\models\User;

class ManageContent extends BasePermission
{

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        User::USERGROUP_SELF,
        User::USERGROUP_FRIEND,
        User::USERGROUP_USER,
        User::USERGROUP_GUEST
    ];

    /**
     * @inheritdoc
     */
    protected $defaultAllowedGroups = [
        User::USERGROUP_SELF
    ];

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
    protected $moduleId = 'content';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->title = \Yii::t('ContentModule.permissions', 'Manage content');
        $this->description = \Yii::t('ContentModule.permissions', 'Can manage (e.g. archive, stick or delete) arbitrary content');
    }
}
