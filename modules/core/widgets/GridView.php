<?php

namespace zikwall\easyonline\modules\core\widgets;

/**
 * @inheritdoc
 */
class GridView extends \yii\grid\GridView
{

    const EVENT_INIT = 'init';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->trigger(self::EVENT_INIT);
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public $tableOptions = ['class' => 'table'];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $loaderJs = '$(document).on("ready pjax:success", function () {
                $(".grid-view-loading").show();
                $(".grid-view-loading").css("display", "block !important");
                $(".grid-view-loading").css("opacity", "1 !important");
        });';

        $this->getView()->registerJs($loaderJs);

        return parent::run();
    }

}
