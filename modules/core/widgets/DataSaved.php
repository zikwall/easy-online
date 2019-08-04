<?php

namespace zikwall\easyonline\modules\core\widgets;

class DataSaved extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('dataSaved', []);
    }

}
