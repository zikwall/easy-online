<?php

namespace zikwall\easyonline\modules\user\models\forms;

use Yii;
use zikwall\easyonline\modules\user\components\CheckPasswordValidator;

/**
 * AccountDelete is the model for account deletion.
 *
 * @since 0.5
 */
class AccountDelete extends \yii\base\Model
{

    /**
     * @var string the current password
     */
    public $currentPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        if (!CheckPasswordValidator::hasPassword()) {
            return [];
        }

        return [
            ['currentPassword', 'required'],
            ['currentPassword', CheckPasswordValidator::class],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'currentPassword' => Yii::t('UserModule.forms_AccountDeleteForm', 'Your password'),
        );
    }

}
