<?php

namespace zikwall\easyonline\modules\installer\forms;

use Yii;

class ConfigBasicForm extends \yii\base\Model
{

    /**
     * @var string name of installation
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('InstallerModule.forms_ConfigBasicForm', 'Name of your network'),
        ];
    }

}
