<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use yii\helpers\Html;

class CommunityPickerField extends \zikwall\easyonline\modules\core\widgets\BasePickerField
{
    /**
     * @inheritdoc
     * Min guids string value of Community model equal 2
     */
    public $minInput = 2;

    /**
     * @inheritdoc
     */
    public $defaultRoute = '/community/browse/search-json';
    public $itemClass = \zikwall\easyonline\modules\community\models\Community::class;
    public $itemKey = 'guid';

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $result = parent::getData();
        $allowMultiple = $this->maxSelection !== 1;
        $result['placeholder'] = Yii::t('CommunityModule.widgets_CommunityPickerField', 'Select {n,plural,=1{community} other{communitys}}', ['n' => ($allowMultiple) ? 2 : 1]);
        $result['placeholder-more'] = Yii::t('CommunityModule.widgets_CommunityPickerField', 'Add Community');
        $result['no-result'] = Yii::t('CommunityModule.widgets_CommunityPickerField', 'No communitys found for the given query');

        if ($this->maxSelection) {
            $result['maximum-selected'] = Yii::t('CommunityModule.widgets_CommunityPickerField', 'This field only allows a maximum of {n,plural,=1{# community} other{# communitys}}', ['n' => $this->maxSelection]);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function getItemText($item)
    {
        return Html::encode($item->getDisplayName());
    }

    /**
     * @inheritdoc
     */
    protected function getItemImage($item)
    {
        return Image::widget(["community" => $item, "width" => 24]);
    }

}
