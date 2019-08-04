<?php

namespace zikwall\easyonline\modules\community\modules\manage\components;

use zikwall\easyonline\modules\admin\permissions\ManageCommunitys;
use Yii;
use yii\web\HttpException;

class Controller extends \zikwall\easyonline\modules\content\components\ContentContainerController
{
    /**
     * @inheritdoc
     */
    public $hideSidebar = true;

    /**
     * @return array
     */
    protected function getAccessRules() {
        return [
            ['login'],
            [
                'permission' => [
                    ManageCommunitys::class
                ]
            ]
        ];
    }
}
