<?php

namespace zikwall\easyonline\modules\community\permissions;

use zikwall\easyonline\modules\community\models\Type;
use zikwall\easyonline\modules\core\libs\BasePermission;

class CreateCommunityType extends BasePermission
{
    /**
     * @var Type
     */
    public $communityType;

    /**
     * @inheritdoc
     */
    protected $title = "Create space type";

    /**
     * @inheritdoc
     */
    protected $description = "Can create space type";

    /**
     * @inheritdoc
     */
    protected $moduleId = 'enterprise';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 'create_community_type_' . $this->communityType->id;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title . ": " . $this->communityType->item_title;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description . ": " . $this->communityType->item_title;
    }

}
