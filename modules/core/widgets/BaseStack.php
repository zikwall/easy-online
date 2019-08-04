<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;

class BaseStack extends \yii\base\Widget
{

    const EVENT_INIT = 'init';
    const EVENT_RUN = 'run';

    /**
     * Сохраняет все добавленные виджеты
     *
     * Format:
     *  [0] Classname
     *  [1] Params Arrays
     *  [2] Additional Options
     *
     * @var array
     */
    public $widgets = [];

    /**
     * Seperator HTML Code (glue)
     *
     * @var string
     */
    public $seperator = "";

    /**
     * Шаблон для вывода
     * Заполнитель {content} будет использоваться для добавления контента.
     *
     * @var string
     */
    public $template = "{content}";

    public function init()
    {
        if (version_compare(Yii::getVersion(), '2.0.11', '<')) {
            $this->trigger(self::EVENT_INIT);
        }

        parent::init();
    }

    public function run()
    {
        $this->trigger(self::EVENT_RUN);

        $content = "";

        $i = 0;
        foreach ($this->getWidgets() as $widget) {
            $i++;

            $widgetClass = $widget[0];

            $out = $widgetClass::widget($widget[1]);

            if (!empty($out)) {
                $content .= $out;
                if ($i != count($this->getWidgets())) {
                    $content .= $this->seperator;
                }
            }
        }

        return str_replace('{content}', $content, $this->template);
    }

    public function removeWidget($className)
    {
        foreach ($this->widgets as $k => $widget) {
            if ($widget[0] === $className) {
                unset($this->widgets[$k]);
            }
        }
    }

    protected function getWidgets()
    {

        usort($this->widgets, function($a, $b) {
            $sortA = (isset($a[2]['sortOrder'])) ? $a[2]['sortOrder'] : 100;
            $sortB = (isset($b[2]['sortOrder'])) ? $b[2]['sortOrder'] : 100;

            if ($sortA == $sortB) {
                return 0;
            } else if ($sortA < $sortB) {
                return -1;
            } else {
                return 1;
            }
        });

        return $this->widgets;
    }

    public function addWidget($className, $params = [], $options = [])
    {
        if (!isset($options['sortOrder'])) {
            $options['sortOrder'] = 100;
        }

        $this->widgets[] = [
            $className,
            $params,
            $options
        ];
    }

}
