<?php
namespace zikwall\easyonline\modules\core\widgets;

class ModalDialog extends Modal
{
    
    public $dialogContent;

    public $template = 'modalDialog';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!$this->body && !$this->footer) {
            ob_start();
            ob_implicit_flush(false);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!$this->body && !$this->footer) {
            $this->dialogContent = ob_get_clean();
        }

        $showClose = ($this->showClose != null) ? $this->showClose : ($this->header != null);
        
        $dialogClass = 'modal-dialog';
        $dialogClass .= ($this->size != null) ? ' modal-dialog-'.$this->size : '';
        $dialogClass .= ($this->animation != null) ? ' animated '.$this->animation : '';
        
        $bodyClass = 'modal-body';
        $bodyClass .= ($this->centerText) ? ' text-center' : '';

        $this->initialLoader = ($this->initialLoader ==! null) ? $this->initialLoader : ($this->body === null);
       
        $modalData = '';
        $modalData .= !$this->backdrop ? 'data-backdrop="static"' : '';
        $modalData .= !$this->keyboard ? 'data-keyboard="false"' : '';
        $modalData .= $this->show ? 'data-show="true"' : '';
        
        return $this->render($this->template, [
            'header' => $this->header,
            'dialogContent' => $this->dialogContent,
            'body' => $this->body,
            'bodyClass' => $bodyClass,
            'footer' => $this->footer,
            'dialogClass' => $dialogClass,
            'initialLoader' => $this->initialLoader,
            'showClose' => $showClose
        ]);
    }
}
