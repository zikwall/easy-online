<?php

namespace zikwall\easyonline\modules\community\permissions;

use zikwall\easyonline\modules\core\libs\BasePermission;

class CreatePrivateCommunity extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'create_private_community';
    
    /**
     * @inheritdoc
     */
    protected $title = 'Create private community';

    /**
     * @inheritdoc
     */
    protected $description = 'Can create hidden (private) communitys.';

    /**
     * @inheritdoc
     */
    protected $moduleId = 'community';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    public function __construct($config = array()) {
        parent::__construct($config);
        
        $this->title = \Yii::t('CommunityModule.permissions', 'Create private community');
        $this->description = \Yii::t('CommunityModule.permissions', 'Can create hidden (private) communitys.');
    }    
}
