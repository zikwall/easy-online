<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\widgets\Button;

class Link extends Button
{
    /**
     * @var bool
     */
    public $_link = true;

    /**
     * @param $text
     * @param string $url
     * @param bool $pjax
     * @return mixed
     */
    public static function to($text, $url = '#', $pjax = true) {
        return self::asLink($text, $url)->pjax($pjax);
    }

    /**
     * @param $text
     * @param $action
     * @param null $url
     * @param null $target
     * @return mixed
     */
    public static function withAction($text, $action, $url = null, $target = null) {
        return self::asLink($text)->action($action,$url, $target);
    }

    /**
     * @param $url
     * @return $this
     */
    public function post($url)
    {
        // Note data-method automatically prevents pjax
        $this->href($url);
        $this->htmlOptions['data-method'] = 'POST';
        return $this;
    }

    /**
     * @param string $url
     * @param bool $pjax
     * @return $this
     */
    public function href($url = '#', $pjax = true)
    {
        $this->link($url);
        $this->pjax($pjax);
        return $this;
    }
}
