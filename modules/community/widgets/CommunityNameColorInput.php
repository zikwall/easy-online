<?php

namespace zikwall\easyonline\modules\community\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;

class CommunityNameColorInput extends Widget
{

    public $model;
    public $form;

    public function run()
    {
        return $this->render('communityNameColorInput', [
            'model' => $this->model,
            'form' => $this->form
        ]);
    }
}

?>
