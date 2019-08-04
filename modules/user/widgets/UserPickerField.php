<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use \yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\BasePickerField;

class UserPickerField extends BasePickerField
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = '/user/search/json';

    /**
     * @inheritdoc
     */
    public $jsWidget = 'user.picker.UserPicker';

    /**
     * @inheritdoc
     */
    public function init() {
        $this->itemClass = \zikwall\easyonline\modules\user\models\User::class;
        $this->itemKey = 'guid';
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        if (!$this->url) {
            return Url::to([$this->defaultRoute]);
        }

        return parent::getUrl();
    }

    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $result = parent::getData();
        $allowMultiple = $this->maxSelection !== 1;
        $result['placeholder'] = ($this->placeholder != null) ? $this->placeholder : Yii::t('UserModule.widgets_UserPickerField', 'Select {n,plural,=1{user} other{users}}', ['n' => ($allowMultiple) ? 2 : 1]);

        if ($this->placeholder && !$this->placeholderMore) {
            $result['placeholder-more'] = $this->placeholder;
        } else {
            $result['placeholder-more'] = ($this->placeholderMore) ? $this->placeholderMore : Yii::t('UserModule.widgets_UserPickerField', 'Add more...');
        }

        $result['no-result'] = Yii::t('UserModule.widgets_UserPickerField', 'No users found for the given query.');

        if ($this->maxSelection) {
            $result['maximum-selected'] = Yii::t('UserModule.widgets_UserPickerField', 'This field only allows a maximum of {n,plural,=1{# user} other{# users}}.', ['n' => $this->maxSelection]);
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function getItemText($item)
    {
        return \yii\helpers\Html::encode($item->displayName);
    }
}
