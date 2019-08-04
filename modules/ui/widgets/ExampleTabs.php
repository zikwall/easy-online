<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\widgets\BaseMenu;
use yii\helpers\Url;

class ExampleTabs extends BaseMenu
{
    public $template = '@easyonline/modules/core/widgets/views/tabMenu';

    public function init()
    {
        $this->addItem([
            'label' => 'Таб 1',
            'url' => Url::to('/example'),
            'sortOrder' => 100,
            'isActive' => true,
        ]);

        $this->addItem([
            'label' => 'Таб 2',
            'url' => Url::to('/example'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => 'Таб 3',
            'url' => Url::to('/example'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => 'Таб 4',
            'url' => Url::to('/example'),
            'sortOrder' => 100,
        ]);
    }

}

?>
