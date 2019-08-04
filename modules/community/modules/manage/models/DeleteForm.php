<?php


namespace zikwall\easyonline\modules\community\modules\manage\models;

use Yii;
use yii\base\Model;
use zikwall\easyonline\modules\user\components\CheckPasswordValidator;

/**
 * Form Model for Community Deletion
 *
 * @since 0.5
 */
class DeleteForm extends Model
{

    /**
     * @var string users password
     */
    public $currentPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            array('currentPassword', 'required'),
            array('currentPassword', CheckPasswordValidator::class),
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'currentPassword' => Yii::t('CommunityModule.forms_CommunityDeleteForm', 'Your password'),
        );
    }

}
