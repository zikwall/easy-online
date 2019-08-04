<?php

namespace zikwall\easyonline\modules\core\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;


class JsWidget extends Widget
{

    /**
     * Определяет идентификатор поля ввода select
     *
     * @var string
     */
    public $id;

    /**
     * Сообщество имен JsWidget
     * @var string
     */
    public $jsWidget;

    /*
     * Используется для перезаписи атрибутов поля ввода. Этот массив можно использовать для перезаписи
     * текста или других параметров выбора.
     *
     * @var string
     */
    public $options = [];

    /**
     * Обработчик событий.
     * @var array
     */
    public $events = [];

    /**
     * Автоматический флаг инициализации
     * @var bool
     */
    public $init = false;

    /**
     * Используется для скрытия/отображения фактического элемента ввода
     * @var bool
     */
    public $visible = true;

    /**
     * @var string элемент контейнера html
     */
    public $container = 'div';

    /**
     * @var string html content.
     */
    public $content;

    /**
     * Реализация JsWidget по умолчанию.
     * Это приведет к отображению элемента html виджета, указанного в $container и $content, и заданных атрибутах $options/$event.
     * Эта метод должен быть перезаписан для виджетов с более сложной визуализацией.
     *
     * @return string
     */
    public function run()
    {
        return \yii\helpers\Html::tag($this->container, $this->content, $this->getOptions());
    }

    /**
     * Скомпилирует все атрибуты виджета и настройки данных этого виджета.
     * Эти атрибуты/параметры обычно передаются клиенту js обычными атрибутами html или используя атрибуты data- *.
     *
     * @return array
     */
    protected function getOptions()
    {
        $attributes = $this->getAttributes();
        $attributes['data'] = $this->getData();
        $attributes['id'] = $this->getId();

        $this->setDefaultOptions();

        $result = \yii\helpers\ArrayHelper::merge($attributes, $this->options);

        if (!$this->visible) {
            if (isset($result['style'])) {
                $result['style'] .= ';display:none;';
            } else {
                $result['style'] = 'display:none;';
            }
        }

        return $result;
    }

    /**
     * Устанавливает некоторые параметры данных по умолчанию, необходимые всем виджетам в качестве реализации виджета
     * и запускает виджет evetns и инициализации.
     */
    public function setDefaultOptions()
    {
        // Set event data
        foreach ($this->events as $event => $handler) {
            $this->options['data']['widget-action-' . $event] = $handler;
        }

        $this->options['data']['ui-widget'] = $this->jsWidget;

        if (!empty($this->init)) {
            $this->options['data']['ui-init'] = $this->init;
        }
    }

    public function getId($autoGenerate = true)
    {
        if ($this->id) {
            return $this->id;
        }

        return $this->id = parent::getId($autoGenerate);
    }

    /**
     * Возвращает массив атрибутов data- * для настройки вашего виджетов javascript.
     * Обратите внимание, что эта функция не требует добавления префикса данных. Это будет сделано Yii.
     *
     * Атрибуты data- * должны быть вставлены в корневой элемент виджета.
     *
     * @return []
     */
    protected function getData()
    {
        return [];
    }

    /**
     * Возвращает все атрибуты html для этого виджета и обычно вставляется в элемент xhml элемента widgets.
     *
     * @return []
     */
    protected function getAttributes()
    {
        return [];
    }

}
