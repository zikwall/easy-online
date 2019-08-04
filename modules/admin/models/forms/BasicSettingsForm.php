<?php

namespace zikwall\easyonline\modules\admin\models\forms;

use Yii;
use zikwall\easyonline\modules\core\libs\DynamicConfig;

class BasicSettingsForm extends \yii\base\Model
{
    public $name;
    public $baseUrl;
    public $defaultLanguage;
    public $tour;
    public $timeZone;
    public $dashboardShowProfilePostForm;
    public $enableFriendshipModule;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->name = Yii::$app->settings->get('name');
        $this->baseUrl = Yii::$app->settings->get('baseUrl');
        $this->defaultLanguage = Yii::$app->settings->get('defaultLanguage');
        $this->timeZone = Yii::$app->settings->get('timeZone');
        $this->enableFriendshipModule = Yii::$app->getModule('friendship')->settings->get('enable');

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'baseUrl'], 'required'],
            ['name', 'string', 'max' => 150],
            ['defaultLanguage', 'in', 'range' => array_keys(Yii::$app->i18n->getAllowedLanguages())],
            ['timeZone', 'in', 'range' => \DateTimeZone::listIdentifiers()],
            [['tour', 'dashboardShowProfilePostForm', 'enableFriendshipModule'], 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Name of the application'),
            'baseUrl' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Base URL'),
            'defaultLanguage' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Default language'),
            'timeZone' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Server Timezone'),
            'tour' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Show introduction tour for new users'),
            'dashboardShowProfilePostForm' => Yii::t('AdminModule.forms_BasicSettingsForm',
                'Show user profile post form on dashboard'),
            'enableFriendshipModule' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Enable user friendship system'),
        ];
    }

    public function save() : bool
    {
        Yii::$app->settings->set('name', $this->name);
        Yii::$app->settings->set('baseUrl', $this->baseUrl);
        Yii::$app->settings->set('defaultLanguage', $this->defaultLanguage);
        Yii::$app->settings->set('timeZone', $this->timeZone);
        Yii::$app->getModule('friendship')->settings->set('enable', $this->enableFriendshipModule);

        DynamicConfig::rewrite();

        return true;
    }
}
