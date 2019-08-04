<?php

namespace zikwall\easyonline\modules\core\widgets;

class ActiveField extends \yii\bootstrap\ActiveField
{

    /**
     * @inheritdoc
     */
    public function widget($class, $config = [])
    {
        /* @var $class \yii\base\Widget */
        $config['model'] = $this->model;
        $config['attribute'] = $this->attribute;
        $config['view'] = $this->form->getView();

        if (isset($config['options']) && isset(class_parents($class)['zikwall\easyonline\modules\core\widgets\InputWidget'])) {
            $this->adjustLabelFor($config['options']);
        }

        return parent::widget($class, $config);
    }

}
