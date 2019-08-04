<?php

namespace zikwall\easyonline\modules\core\modules\developer\widgets;

use Yii;

class PanelRow extends \yii\base\Widget
{

    public $items;
    
    public function run()
    {
        return $this->render('panelRow', [
            'items' => $this->items,
        ]);
    }
}

?>
