<?php

namespace zikwall\easyonline\modules\core\widgets;


use zikwall\easyonline\modules\core\components\base\Widget;
use zikwall\easyonline\modules\core\libs\Html;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use zikwall\easyonline\modules\ui\widgets\BootstrapInterface;

/**
 * Класс помощника для создания кнопок.
 *
 *  e.g:
 *
 * `<?= Button::primary('Some Text')->actionClick('myHandler', [/some/url])->sm() ?>`
 *
 */
class Button extends BootstrapInterface
{
    const TYPE_PRIMARY = 'primary';
    const TYPE_DEFAULT = 'default';
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';
    const TYPE_SUCCESS = 'success';
    const TYPE_NONE = 'none';

    public $type;
    public $htmlOptions = [];
    public $text;
    public $_icon;

    public $_loader = true;

    public $_link = false;

    public static function instance($text = null)
    {
        return new self(['text' => $text]);
    }

    /**
     * @inheritdoc
     */
    public function getComponentBaseClass()
    {
        return 'btn';
    }
    /**
     * @inheritdoc
     */
    public function getTypedClass($type)
    {
        return 'btn-'.$type;
    }

    /**
     * @return string renders and returns the actual html element by means of the current settings
     */
    public function renderComponent()
    {
        if ($this->_loader) {
            $this->htmlOptions['data-ui-loader'] = '';
        }
        // Workaround since data-method handler prevents confirm or other action handlers from being executed.
        if (isset($this->htmlOptions['data-action-confirm']) && isset($this->htmlOptions['data-method'])) {
            $method = $this->htmlOptions['data-method'];
            $this->htmlOptions['data-method'] = null;
            $this->htmlOptions['data-action-method'] = $method;
        }
        if ($this->_link) {
            $href = isset($this->htmlOptions['href']) ? $this->htmlOptions['href'] : null;
            return Html::a($this->getText(), $href, $this->htmlOptions);
        } else {
            return Html::button($this->getText(), $this->htmlOptions);
        }
    }

    /**
     * @param string $text Button text
     * @return static
     */
    public static function save($text = null)
    {
        if (!$text) {
            $text = Yii::t('base', 'Save');
        }
        return self::primary($text);
    }

    public static function back($url, $text = null)
    {
        if (!$text) {
            $text = Yii::t('base', 'Back');
        }

        $instance = self::defaultType($text);
        return $instance->link($url)->icon('fa-arrow-left')->right();
    }

    public static function none($text = null)
    {
        return new self(['type' => self::TYPE_NONE, 'text' => $text]);
    }

    public static function primary($text = null)
    {
        return new self(['type' => self::TYPE_PRIMARY, 'text' => $text]);
    }

    public static function defaultType($text = null)
    {
        return new self(['type' => self::TYPE_DEFAULT, 'text' => $text]);
    }

    public static function info($text = null)
    {
        return new self(['type' => self::TYPE_INFO, 'text' => $text]);
    }

    public static function warning($text = null)
    {
        return new self(['type' => self::TYPE_WARNING, 'text' => $text]);
    }

    public static function success($text = null)
    {
        return new self(['type' => self::TYPE_SUCCESS, 'text' => $text]);
    }

    public static function danger($text = null)
    {
        return new self(['type' => self::TYPE_DANGER, 'text' => $text]);
    }

    public function loader($active = true)
    {
        $this->_loader = $active;
        return $this;
    }

    public function link($url = null)
    {
        $this->_link = true;
        $this->htmlOptions['href'] = Url::to($url);
        return $this;
    }

    public function right($right = true)
    {
        if ($right) {
            Html::removeCssClass($this->htmlOptions,'pull-left');
            Html::addCssClass($this->htmlOptions, 'pull-right');
        } else {
            Html::removeCssClass($this->htmlOptions,'pull-right');
        }

        return $this;
    }

    public function left($left = true)
    {
        if ($left) {
            Html::removeCssClass($this->htmlOptions,'pull-right');
            Html::addCssClass($this->htmlOptions, 'pull-left');
        } else {
            Html::removeCssClass($this->htmlOptions,'pull-left');
        }

        return $this;
    }

    public function sm()
    {
        Html::addCssClass($this->htmlOptions, 'btn-sm');
        return $this;
    }

    public function lg()
    {
        Html::addCssClass($this->htmlOptions, 'btn-lg');
        return $this;
    }

    public function xs()
    {
        Html::addCssClass($this->htmlOptions, 'btn-xs');
        return $this;
    }

    public function submit()
    {
        $this->htmlOptions['type'] = 'submit';
        return $this;
    }

    public function style($style)
    {
        Html::addCssStyle($this->htmlOptions, $style);
        return $this;
    }

    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function cssClass($cssClass)
    {
        Html::addCssClass($this->htmlOptions, $cssClass);
        return $this;
    }

    public function options($options)
    {
        $this->htmlOptions = ArrayHelper::merge($this->htmlOptions, $options);
        return $this;
    }

    public function action($handler, $url = null, $target = null)
    {
        return $this->onAction('click', $handler, $url, $target);
    }

    public function onAction($event, $handler, $url = null, $target = null)
    {
        $this->htmlOptions['data-action-'.$event] = $handler;

        if ($url) {
            $this->htmlOptions['data-action-'.$event.'-url'] = Url::to($url);
        }

        if ($target) {
            $this->htmlOptions['data-action-'.$event.'-target'] = $target;
        }

        return $this;
    }

    public function confirm($title = null, $body = null, $confirmButtonText = null, $cancelButtonText = null)
    {
        if ($title) {
            $this->htmlOptions['data-action-confirm-header'] = $title;
        }

        if ($body) {
            $this->htmlOptions['data-action-confirm'] = $body;
        } else {
            $this->htmlOptions['data-action-confirm'] = '';
        }

        if ($confirmButtonText) {
            $this->htmlOptions['data-action-confirm-text'] = $confirmButtonText;
        }

        if ($cancelButtonText) {
            $this->htmlOptions['data-action-cancel-text'] = $cancelButtonText;
        }

        return $this;
    }

    public function icon($content, $raw = false)
    {
        if (!$raw) {
            $this->icon(Html::tag('i', '', ['class' => 'fa '.$content]), true);
        } else {
            $this->_icon = $content;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->setCssClass();

        if ($this->_loader) {
            $this->htmlOptions['data-ui-loader'] = '';
        }

        $this->htmlOptions['id'] = $this->getId(true);

        if ($this->_link) {
            $href = isset($this->htmlOptions['href']) ? $this->htmlOptions['href'] : null;
            return Html::a($this->getText(), $href, $this->htmlOptions);
        } else {
            return Html::button($this->getText(), $this->htmlOptions);
        }
    }

    protected function setCssClass()
    {
        if ($this->type !== self::TYPE_NONE) {
            Html::addCssClass($this->htmlOptions, 'btn');
            Html::addCssClass($this->htmlOptions, 'btn-'.$this->type);
        }
    }

    protected function getText()
    {
        if ($this->_icon) {
            return $this->_icon.' '.$this->text;
        }

        return $this->text;
    }

    public function __toString()
    {
        return $this::widget([
            'id' => $this->id,
            'type' => $this->type,
            'text' => $this->text,
            'htmlOptions' => $this->htmlOptions,
            '_icon' => $this->_icon,
            '_link' => $this->_link,
            '_loader' => $this->_loader,
        ]);
    }

    public function load()
    {
        return $this;
    }
}
