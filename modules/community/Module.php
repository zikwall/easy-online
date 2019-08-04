<?php

namespace zikwall\easyonline\modules\community;

use zikwall\easyonline\modules\community\permissions\ManageCommunity;
use zikwall\easyonline\modules\user\models\User;
use Yii;

class Module extends \zikwall\easyonline\modules\core\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamecommunity = 'zikwall\easyonline\modules\community\controllers';

    /**
     * @var boolean Allow global admins (super admin) access to private content also when no member
     */
    public $globalAdminCanAccessPrivateContent = false;

    /**
     *
     * @var boolean Do not allow multiple communitys with the same name
     */
    public $useUniqueCommunityNames = true;

    /**
     * @var boolean defines if the community following is disabled or not.
     * @since 1.2
     */
    public $disableFollow = false;

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof models\Community) {
            return [
                new permissions\InviteUsers(),
            ];
        } elseif ($contentContainer instanceof User) {
            return [];
        }

        return [
            new permissions\CreatePrivateCommunity(),
            new permissions\CreatePublicCommunity(),
            new ManageCommunity(),
        ];
    }

    public function getName()
    {
        return Yii::t('CommunityModule.base', 'Community');
    }
}
