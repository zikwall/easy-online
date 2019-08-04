<?php

namespace zikwall\easyonline\modules\core\widgets;

class ModalClose extends \yii\base\Widget
{
    public $success;
    public $info;
    public $error;
    public $warn;
    public $saved;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return $this->render('modalClose', [
            'success' => $this->success,
            'info' => $this->info,
            'error' => $this->error,
            'warn' => $this->warn,
            'saved' => $this->saved,
        ]);
    }
}
