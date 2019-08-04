<?php

namespace zikwall\easyonline\modules\core\widgets;

class PanelMenu extends \yii\base\Widget
{
    public $id = "";

    public $extraMenus = "";

    public function init()
    {
        return parent::init();
    }

    public function run()
    {
        return $this->render('panelMenu', [
            'id' => $this->id,
            'extraMenus' => $this->extraMenus,
        ]);
    }

}

?>
