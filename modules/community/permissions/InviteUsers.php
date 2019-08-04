<?php

namespace zikwall\easyonline\modules\community\permissions;

use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\core\libs\BasePermission;

class InviteUsers extends BasePermission
{
    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Community::USERGROUP_OWNER,
        Community::USERGROUP_ADMIN,
        Community::USERGROUP_MODERATOR,
        Community::USERGROUP_MEMBER,
    ];

    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
        Community::USERGROUP_USER,
        Community::USERGROUP_GUEST,
    ];

    /**
     * @inheritdoc
     */
    protected $title = 'Invite users';

    /**
     * @inheritdoc
     */
    protected $description = 'Allows the user to invite new members to the community';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'community';

    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->title = \Yii::t('CommunityModule.permissions', 'Invite users');
        $this->description = \Yii::t('CommunityModule.permissions', 'Allows the user to invite new members to the community');
    }

}
