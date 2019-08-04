<?php

namespace zikwall\easyonline\modules\community\widgets;

use \yii\base\Widget;

class Wall extends Widget
{

    public $community;

    public function run()
    {
        return $this->render('communityWall', array('community' => $this->community));
    }

}

?>
