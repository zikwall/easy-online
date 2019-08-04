<?php

namespace zikwall\easyonline\modules\content;

use Yii;

class Module extends \zikwall\easyonline\modules\core\components\Module
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('ContentModule.base', 'Content');
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer !== null) {
            return [
                new permissions\ManageContent(),
            ];
        }

        return [];
    }

}
