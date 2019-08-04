<?php

namespace zikwall\easyonline\modules\ui\widgets;

use yii\helpers\Html;
use zikwall\easyonline\modules\core\components\base\Widget;

class Label extends BootstrapInterface
{
    public $_sortOrder = 1000;
    public $encode = true;
    public $_link;
    public $_action;
    public function sortOrder($sortOrder)
    {
        $this->_sortOrder = $sortOrder;
        return $this;
    }

    public function action($handler, $url = null, $target = null)
    {
        $this->_link = Link::withAction($this->getText(), $handler, $url, $target);
        return $this;
    }

    public function withLink($link)
    {
        if ($link instanceof Link) {
            $this->_link = $link;
        }
        return $this;
    }

    public function renderComponent()
    {
        $result = Html::tag('span', $this->getText(), $this->htmlOptions);
        if ($this->_link) {
            $result = (string) $this->_link->setText($result);
        }
        return $result;
    }

    public function getComponentBaseClass()
    {
        return 'label';
    }

    public function getTypedClass($type)
    {
        return 'label-'.$type;
    }

    public function getWidgetOptions()
    {
        $options = parent::getWidgetOptions();
        $options['_link'] = $this->_link;
        return $options;
    }

    public static function sort(&$labels)
    {
        usort($labels, function ($a, $b) {
            if ($a->_sortOrder == $b->_sortOrder) {
                return 0;
            } elseif ($a->_sortOrder < $b->_sortOrder) {
                return - 1;
            } else {
                return 1;
            }
        });
        return $labels;
    }
}
