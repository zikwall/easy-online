<?php

namespace zikwall\easyonline\modules\community\permissions;

use zikwall\easyonline\modules\core\libs\BasePermission;

class CreatePublicCommunity extends BasePermission
{
    /**
     * @inheritdoc
     */
    protected $id = 'create_public_community';

    /**
     * @inheritdoc
     */
    protected $title = 'Create public community';

    /**
     * @inheritdoc
     */
    protected $description = 'Can create public visible communitys. (Listed in directory)';

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
        
        $this->title = \Yii::t('CommunityModule.permissions', 'Create public community');
        $this->description = \Yii::t('CommunityModule.permissions', 'Can create public visible communitys. (Listed in directory)');
    }

}
