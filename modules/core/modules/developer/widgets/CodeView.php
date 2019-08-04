<?php

namespace frontend\modules\devtools\widgets;

use zikwall\easyonline\modules\core\widgets\MarkdownView;

class CodeView extends \yii\base\Widget
{

    public $type = '';
    
    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $content = ob_get_clean();
        $codeblock = '```'.$this->type.$content.'```';
        return MarkdownView::widget(['markdown' => $codeblock]);
    }
}

?>
