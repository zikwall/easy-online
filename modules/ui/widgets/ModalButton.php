<?php

namespace zikwall\easyonline\modules\ui\widgets;

use zikwall\easyonline\modules\core\widgets\Button;

class ModalButton extends Button
{
    /**
     * @param $url
     * @return Button
     */
    public function load($url)
    {
        return $this->action('ui.modal.load', $url)->loader(false);
    }

    /**
     * @param $url
     * @return Button
     */
    public function post($url)
    {
        return $this->action('ui.modal.post', $url)->loader(false);
    }

    /**
     * @param $target
     * @return Button
     */
    public function show($target)
    {
        return $this->action('ui.modal.show', null, $target);
    }

    /**
     * @param null $url
     * @param null $text
     * @return mixed
     */
    public static function submitModal($url = null, $text = null)
    {
        if (!$text) {
            $text = Yii::t('base', 'Save');
        }
        return static::save($text)->submit()->action('ui.modal.submit', $url);
    }

    /**
     * @param null $text
     * @return mixed
     */
    public static function cancel($text = null)
    {
        if (!$text) {
            $text = Yii::t('base', 'Cancel');
        }
        return static::defaultType($text)->close()->loader(false);
    }

    /**
     * @return ModalButton
     */
    public function close()
    {
        return $this->options(['data-modal-close' => '']);
    }
}
