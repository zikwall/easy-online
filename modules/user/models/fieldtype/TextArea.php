<?php

namespace zikwall\easyonline\modules\user\models\fieldtype;

use Yii;

/**
 * ProfileFieldTypeTextArea handles text area profile fields.
 *
 * @package encore.modules_core.user.models
 * @since 0.5
 */
class TextArea extends BaseType
{

    /**
     * Rules for validating the Field Type Settings Form
     *
     * @return type
     */
    public function rules()
    {
        return array(
                #array('maxLength, alphaNumOnly', 'safe'),
        );
    }

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return Array Form Definition
     */
    public function getFormDefinition($definition = array())
    {
        return parent::getFormDefinition(array(
                    get_class($this) => array(
                        'type' => 'form',
                        'title' => Yii::t('UserModule.models_ProfileFieldTypeTextArea', 'Text area field options'),
                        'elements' => array(
                        )
        )));
    }

    /**
     * Saves this Profile Field Type
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!\app\modules\user\models\Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(\app\modules\user\models\Profile::tableName(), $columnName, 'TEXT');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * Returns the Field Rules, to validate users input
     *
     * @param type $rules
     * @return type
     */
    public function getFieldRules($rules = array())
    {

        $rules[] = array($this->profileField->internal_name, 'safe');

        return parent::getFieldRules($rules);
    }

    /**
     * Return the Form Element to edit the value of the Field
     */
    public function getFieldFormDefinition()
    {
        return array($this->profileField->internal_name => array(
                'type' => 'textarea',
                'class' => 'form-control',
                'rows' => '3'
        ));
    }

}

?>
