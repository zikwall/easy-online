<?php

namespace zikwall\easyonline\modules\core\widgets;

class LoaderWidget extends \yii\base\Widget
{

    /**
     * id for DOM element
     *
     * @var string
     */
    public $id = "";

    /**
     * css classes for DOM element
     *
     * @var string
     */
    public $cssClass = "";

    /**
     * defines if the loader is initially shown
     */
    public $show = true;

    public function run()
    {
        return $this->render('loader', [
            'id' => $this->id,
            'cssClass' => $this->cssClass,
            'show' => $this->show
        ]);
    }

}

?>
