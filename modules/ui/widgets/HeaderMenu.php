<?php

namespace zikwall\easyonline\modules\ui\widgets;

class HeaderMenu extends \yii\base\Widget
{
    public $user;

    public function run()
    {
        return $this->render('headerMenu', [
            'user' => $this->user
        ]);
    }
}

?>
