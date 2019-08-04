<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\widgets\ModalDialog;

class ContentModalDialog extends ModalDialog
{
    /**
     * @var string
     */
    public $template = 'modalDialogContent';

    /**
     * @var string 
     */
    public $content = '';

    /**
     * @var string
     */
    public $title = 'Уведомление';

    /**
     * @var bool 
     */
    public $isDraggable = true;

    /**
     * @var bool
     */
    public $isGrey = false;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render($this->template, [
            'content' => $this->content,
            'title' => $this->title,
            'isDraggable' => $this->isDraggable,
            'isGrey' => $this->isGrey
        ]);
    }
}
