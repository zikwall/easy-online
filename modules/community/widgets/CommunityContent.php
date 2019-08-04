<?php

namespace zikwall\easyonline\modules\community\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;

class CommunityContent extends Widget
{
    /**
     * @var string
     */
    public $content = '';

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    public function run()
    {
        return $this->content;
    }
}
