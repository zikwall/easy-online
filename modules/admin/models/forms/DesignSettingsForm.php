<?php

namespace zikwall\easyonline\modules\admin\models\forms;

use Yii;
use zikwall\easyonline\modules\core\helpers\ThemeHelper;
use zikwall\easyonline\modules\core\components\base\Theme;
use zikwall\easyonline\modules\core\libs\DynamicConfig;

class DesignSettingsForm extends \yii\base\Model
{
    public $theme;
    public $backendTheme;
    public $paginationSize;
    public $displayName;
    public $spaceOrder;
    public $logo;
    public $dateInputDisplayFormat;
    public $horImageScrollOnMobile;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $settingsManager = Yii::$app->settings;

        $this->theme = $settingsManager->get('theme');
        $this->backendTheme = $settingsManager->get('backendTheme');
        $this->paginationSize = $settingsManager->get('paginationSize');
        $this->displayName = $settingsManager->get('displayNameFormat');
        $this->dateInputDisplayFormat = Yii::$app->getModule('admin')->settings->get('defaultDateInputFormat');
        $this->horImageScrollOnMobile = $settingsManager->get('horImageScrollOnMobile');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $themes = [];
        foreach (ThemeHelper::getThemes() as $theme) {
            $themes[] = $theme->name;
        }

        return [
            ['paginationSize', 'integer', 'max' => 200, 'min' => 1],
            ['theme', 'in', 'range' => $themes],
            ['backendTheme', 'in', 'range' => $themes],
            [['displayName', 'spaceOrder'], 'safe'],
            [['horImageScrollOnMobile'], 'boolean'],
            ['logo', 'file', 'extensions' => ['jpg', 'png', 'jpeg'], 'maxSize' => 3 * 1024 * 1024],
            ['logo', 'dimensionValidation', 'skipOnError' => true],
            ['dateInputDisplayFormat', 'in', 'range' => ['', 'php:d/m/Y']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'theme' => Yii::t('AdminModule.forms_DesignSettingsForm', 'Theme'),
            'backendTheme' => 'Тема админки',
            'paginationSize' => Yii::t('AdminModule.forms_DesignSettingsForm', 'Default pagination size (Entries per page)'),
            'displayName' => Yii::t('AdminModule.forms_DesignSettingsForm', 'Display Name (Format)'),
            'spaceOrder' => Yii::t('AdminModule.forms_DesignSettingsForm', 'Dropdown space order'),
            'logo' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Logo upload'),
            'dateInputDisplayFormat' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Date input format'),
            'horImageScrollOnMobile' => Yii::t('AdminModule.forms_BasicSettingsForm', 'Horizontal scrolling images on a mobile device'),
        ];
    }

    /**
     * Проверка размеров
     */
    public function dimensionValidation($attribute, $param)
    {
        if (is_object($this->logo)) {
            list($width, $height) = getimagesize($this->logo->tempName);
            if ($height < 40)
                $this->addError('logo', 'Logo size should have at least 40px of height');
        }
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $files = \yii\web\UploadedFile::getInstancesByName('logo');
        if (count($files) != 0) {
            $file = $files[0];
            $this->logo = $file;
        }

        return parent::load($data, $formName);
    }

    public function save() : bool
    {
        $settingsManager = Yii::$app->settings;

        $settingsManager->set('theme', $this->theme);
        $settingsManager->set('backendTheme', $this->backendTheme);
        $settingsManager->set('paginationSize', $this->paginationSize);
        $settingsManager->set('displayNameFormat', $this->displayName);
        //Yii::$app->getModule('space')->settings->set('spaceOrder', $this->spaceOrder);
        Yii::$app->getModule('admin')->settings->set('defaultDateInputFormat', $this->dateInputDisplayFormat);
        $settingsManager->set('horImageScrollOnMobile', $this->horImageScrollOnMobile);

        DynamicConfig::rewrite();

        return true;
    }

}
