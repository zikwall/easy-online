<?php

namespace zikwall\easyonline\modules\installer\forms;

use Yii;

class UseCaseForm extends \yii\base\Model
{
    /**
     * @var string use case
     */
    public $useCase;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['useCase'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'useCase' => Yii::t('InstallerModule.forms_UseCaseForm', 'I want to use EasyOnline for:'),
        ];
    }

}
