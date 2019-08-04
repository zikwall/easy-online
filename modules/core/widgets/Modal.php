<?php

namespace zikwall\easyonline\modules\core\widgets;

class Modal extends JsWidget
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'ui.modal.Modal';

    /**
     * Header text
     * @var string
     */
    public $header;

    /**
     * Modal content
     * @var string
     */
    public $body;

    /**
     * Modal footer
     * @var string
     */
    public $footer;

    /**
     * Этот параметр повлияет на размер модального диалогового окна.
     * Возможные значения:
     *  - normal
     *  - large
     *  - small
     *  - extra-small
     *  - medium
     * @var string
     */
    public $size;

    /**
     * Может использоваться для добавления открытой анимации для диалога.
     * например: pulse
     *
     * @var string
     */
    public $animation;

    /**
     * Может быть установлено значение true, чтобы заставить кнопку x закрыть, даже если
     * отсутствует headtext, или установлено значение false, если кнопка не должна
     * быть предоставлен.
     *
     * @var boolean
     */
    public $showClose;

    /**
     * Определяет, должен ли щелчок на модальном фонте закрыть модальный
     * @var boolean
     */
    public $backdrop = true;

    /**
     * Определяет, можно ли закрыть модаль, нажав кнопку escape
     * @var boolean
     */
    public $keyboard = true;

    /**
     * Определяет, должен ли модаз отображаться при запуске
     * @var boolean
     */
    public $show = false;

    /**
     * Определяет, должен ли модаз отображаться при запуске
     * @var boolean
     */
    public $centerText = false;

    /**
     * Может быть установлено значение false, если модальное тело не должно быть инициализировано с помощью
     * loader анимация. Значение по умолчанию - true, если тело не предусмотрено.
     *
     * @var boolean
     */
    public $initialLoader;

    public function run()
    {
        return $this->render('modal', [
            'id' => $this->id,
            'options' => $this->getOptions(),
            'header' => $this->header,
            'body' => $this->body,
            'footer' => $this->footer,
            'animation' => $this->animation,
            'size' => $this->size,
            'centerText' => $this->centerText,
            'initialLoader' => $this->initialLoader
        ]);
    }

    public function getAttributes()
    {
        return [
            'class' => "modal",
            'tabindex' => "-1",
            'role' => "dialog",
            'aria-hidden' => "true"
        ];
    }

    public function getData()
    {
        $result = [];

        if (!$this->backdrop) {
            $result['backdrop'] = 'static';
        }

        if (!$this->keyboard) {
            $result['keyboard'] = 'false';
        }

        if ($this->show) {
            $result['show'] = 'true';
        }

        return $result;
    }

}
