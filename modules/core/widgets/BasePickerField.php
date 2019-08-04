<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;
use yii\helpers\Html;
use \yii\helpers\Url;
use zikwall\easyonline\modules\ui\widgets\InputWidget;

/**
 * Абстрактный класс для полей формы сборщика.
 * 
 * Подклассы должны, по крайней мере, перезаписывать следующие поля:
 * 
 * - $defaultRoute для определения маршрута поискового запроса по умолчанию
 * - $itemClass определяет тип элемента, например, пользователь
 * - $itemKey определяет ключевой атрибут, используемый как значения параметра, например, id/guid
 */
abstract class BasePickerField extends InputWidget
{

    /**
     * Определяет реализацию javascript picker.
     * 
     * @var string 
     */
    public $jsWidget = 'ui.picker.Picker';

    public $disabledItems;

    public $defaultRoute;

    /**
     * URL поиска используется для перезаписи маршрута $default для экземпляра сборщика.
     *
     * @var string
     */
    public $url;

    public $maxSelection = 50;

    public $minInput = 3;

    public $maxInput = 20;

    /**
     * Массив экземпляров элементов. Если этот массив установлен, сборщик будет игнорировать
     * фактический атрибут модели и вместо этого использовать этот массив в качестве выбора.
     * 
     * Этот массив не задан, сборщик попытается загрузить элементы с помощью атрибут модели
     * 
     * @see BasePickerField::loadItems
     * @var array 
     */
    public $selection;

    public $defaultResults = [];

    public $itemClass;

    public $itemKey;

    public $form;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    /**
     * @var string 
     */
    public $attribute;

    /**
     * @var string
     */
    public $formName;

    /**
     * @var string
     */
    public $placeholder;

    /**
     * @var string 
     */
    public $placeholderMore;

    /**
     * @var string
     */
    public $focus = false;

    /**
     * @inheritdoc
     * @var boolean 
     */
    public $init = true;

    protected abstract function getItemText($item);

    /**
     * @inhertidoc
     */
    public function run()
    {
        \zikwall\easyonline\modules\core\assets\bootstrap\Select2BootstrapAsset::register($this->view);

        if ($this->selection != null && !is_array($this->selection)) {
            $this->selection = [$this->selection];
        }

        $selection = [];
        $selectedOptions = $this->getSelectedOptions();
        foreach ($selectedOptions as $id => $option) {
            $selection[$id] = $option['data-text'];
        }

        $options = $this->getOptions();
        $options['options'] = $selectedOptions;

        if ($this->form != null) {
            return $this->form->field($this->model, $this->attribute)->dropDownList($selection, $options);
        } else if ($this->model != null) {
            return Html::activeDropDownList($this->model, $this->attribute, $selection, $options);
        } else {
            $name = (!$this->formName) ? 'pickerField' : $this->formName;
            return Html::dropDownList($name, $selection, [], $options);
        }
    }

    /**
     * @return array
     *       Format:
     *
     * [itemKey] => [
     *      'data-text' => itemText
     *      'data-image' => itemImage
     *      'selected' => selected
     * ]
     */
    protected function getSelectedOptions()
    {
        if (!$this->selection && $this->model != null) {
            $attribute = $this->attribute;

            $this->selection = $this->loadItems($this->model->$attribute);
        }

        if (!$this->selection) {
            $this->selection = [];
        }

        $result = [];
        foreach ($this->selection as $item) {
            if (!$item) {
                continue;
            }

            $result[$this->getItemKey($item)] = $this->buildItemOption($item);
        }
        return $result;
    }

    /**
     * @param string $item
     * @param bool $selected
     * @return []
     */
    protected function buildItemOption($item, $selected = true)
    {
        $result = [
            'data-id' => $this->getItemKey($item),
            'data-text' => $this->getItemText($item),
        ];

        if ($selected) {
            $result['selected'] = 'selected';
        }

        return $result;
    }

    protected function getItemKey($item)
    {
        $itemKey = $this->itemKey;
        return $item->$itemKey;
    }

    public function loadItems($selection = null)
    {
        if (empty($selection)) {
            return [];
        }

        if (!is_array($selection)) {
            $selection = explode(',', $selection);
        }

        $itemClass = $this->itemClass;
        return $itemClass::find()->where([$this->itemKey => $selection])->all();
    }

    /*
     * @inheritdoc
     */
    protected function getAttributes()
    {
        return [
            'multiple' => 'multiple',
            'size' => '1',
            'class' => 'form-control',
            'style' => 'width:100%',
            'title' => $this->placeholder
        ];
    }

    protected function getData()
    {
        $allowMultiple = $this->maxSelection !== 1;

        $placeholder = ($this->placeholder != null) ? $this->placeholder : Yii::t('UserModule.widgets_BasePickerField', 'Select {n,plural,=1{item} other{items}}', ['n' => ($allowMultiple) ? 2 : 1]);
        $placeholderMore = ($this->placeholderMore != null) ? $this->placeholderMore : Yii::t('UserModule.widgets_BasePickerField', 'Add more...');

        $result = [
            'picker-url' => $this->getUrl(),
            'picker-focus' => ($this->focus) ? 'true' : null,
            'disabled-items' => (!$this->disabledItems) ? null : $this->disabledItems,
            'maximum-selection-length' => $this->maxSelection,
            'maximum-input-length' => $this->maxInput,
            'minimum-input-length' => $this->minInput,
            'placeholder' => $placeholder,
            'placeholder-more' => $placeholderMore,
            'no-result' => Yii::t('UserModule.widgets_BasePickerField', 'Your search returned no matches.'),
            'format-ajax-error' => Yii::t('UserModule.widgets_BasePickerField', 'An unexpected error occurred while loading the result.'),
            'load-more' => Yii::t('UserModule.widgets_BasePickerField', 'Load more'),
            'input-too-short' => Yii::t('UserModule.widgets_BasePickerField', 'Please enter at least {n} character', ['n' => $this->minInput]),
            'input-too-long' => Yii::t('UserModule.widgets_BasePickerField', 'You reached the maximum number of allowed charachters ({n}).', ['n' => $this->maxInput]),
            'default-results' => $this->getDefaultResultData()
        ];

        if ($this->maxSelection) {
            $result['maximum-selected'] = Yii::t('UserModule.widgets_BasePickerField', 'This field only allows a maximum of {n,plural,=1{# item} other{# items}}.', ['n' => $this->maxSelection]);
        }
        return $result;
    }

    protected function getDefaultResultData()
    {
        $result = [];
        foreach ($this->defaultResults as $item) {
            $result[] = $this->buildItemOption($item);
        }
        return $result;
    }

    protected function getUrl()
    {
        return ($this->url) ? $this->url : Url::to([$this->defaultRoute]);
    }

}
