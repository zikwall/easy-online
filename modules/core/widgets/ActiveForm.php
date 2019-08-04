<?php

namespace zikwall\easyonline\modules\core\widgets;

/**
 * ActiveForm
 */
class ActiveForm extends \yii\bootstrap\ActiveForm
{

    /**
     * @inheritdoc
     */
    public $enableClientValidation = false;

    /**
     * @inheritdoc
     */
    public $fieldClass = 'zikwall\easyonline\modules\core\widgets\ActiveField';

}
