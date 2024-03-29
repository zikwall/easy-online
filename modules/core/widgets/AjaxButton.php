<?php

namespace zikwall\easyonline\modules\core\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

class AjaxButton extends Widget
{

    public $beforeSend;
    public $success;
    public $ajaxOptions = [];
    public $htmlOptions = [];
    public $label = "Unnamed";
    public $tag = 'button';

    public function init()
    {
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

        if (!isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['type'] = new JsExpression('$(this).parents("form").attr("method")');
        }

        if (!isset($this->ajaxOptions['url'])) {
            $this->ajaxOptions['url'] = new JsExpression('$(this).parents("form").attr("action")');
        } else {
            $this->ajaxOptions['url'] = Url::to($this->ajaxOptions['url']);
        }

        if (!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type'])) {
            $this->ajaxOptions['data'] = new JsExpression("$('#{$this->htmlOptions['id']}').closest('form').serialize()");
        }

        if (isset($this->ajaxOptions['beforeSend']) && !$this->ajaxOptions['beforeSend'] instanceof \yii\web\JsExpression) {
            $this->ajaxOptions['beforeSend'] = new JsExpression($this->ajaxOptions['beforeSend']);
        }

        if (isset($this->ajaxOptions['success']) && !$this->ajaxOptions['success'] instanceof \yii\web\JsExpression) {
            $this->ajaxOptions['success'] = new JsExpression($this->ajaxOptions['success']);
        }
    }

    public function run()
    {
        echo Html::tag($this->tag, $this->label, $this->htmlOptions);

        if (isset($this->htmlOptions['return']) && $this->htmlOptions['return'])
            $return = 'return true';
        else
            $return = 'return false';

        $this->view->registerJs("$('#{$this->htmlOptions['id']}').click(function() {
                $.ajax(" . \yii\helpers\Json::encode($this->ajaxOptions) . ");
                    {$return};
            });");
    }

}
