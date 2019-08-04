<?php

namespace zikwall\easyonline\modules\core\widgets;

use yii\helpers\Html;
use yii\web\JsExpression;

class AjaxLinkPager extends LinkPager
{

    /**
     * Вызов Js, который вызывается до запроса Ajax
     *
     * @var string
     */
    public $jsBeforeSend = 'function(){ setModalLoader(); }';

    /**
     * Успешно
     *
     * @var string
     */
    public $jsSuccess = 'function(html){ $("#globalModal").html(html); }';

    /**
     * @inheritdoc
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = ['class' => $class === '' ? null : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);

            return Html::tag('li', Html::tag('span', $label), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;

        return Html::tag('li', AjaxButton::widget([
            'label' => $label,
            'tag' => 'a',
            'ajaxOptions' => [
                'type' => 'POST',
                'beforeSend' => new JsExpression($this->jsBeforeSend),
                'success' => new JsExpression($this->jsSuccess),
                'url' => $this->pagination->createUrl($page),
            ],
            'htmlOptions' => $linkOptions]), $options);
    }

}
