<?php

namespace zikwall\easyonline\modules\installer\forms;

use Yii;

class SampleDataForm extends \yii\base\Model
{

    /**
     * @var boolean create sample data
     */
    public $sampleData;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sampleData'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sampleData' => Yii::t('InstallerModule.forms_SampleDataForm', 'Set up example content (recommended)'),
        ];
    }

}
