<?php

namespace zikwall\easyonline\modules\user\models\fieldtype;

use Yii;
use zikwall\easyonline\modules\core\helpers\Helpers;
use zikwall\easyonline\modules\user\models\Profile;


class BaseType extends \yii\base\Model
{
    public $fieldTypes = array();

    public $profileField = null;

    public function init()
    {
        return parent::init();
    }

    public function onInit($event)
    {
        $this->raiseEvent('onInit', $event);
    }

    public function setProfileField($profileField)
    {
        $this->profileField = $profileField;
        $this->loadFieldConfig();
    }

    public function getFieldTypes()
    {
        $fieldTypes = array_merge(array(
            Number::class => Yii::t('UserModule.models_ProfileFieldType', 'Number'),
            Text::class => Yii::t('UserModule.models_ProfileFieldType', 'Text'),
            TextArea::class => Yii::t('UserModule.models_ProfileFieldType', 'Text Area'),
            Select::class => Yii::t('UserModule.models_ProfileFieldType', 'Select List'),
            Date::class => Yii::t('UserModule.models_ProfileFieldType', 'Date'),
            DateTime::class => Yii::t('UserModule.models_ProfileFieldType', 'Datetime'),
            Birthday::class => Yii::t('UserModule.models_ProfileFieldType', 'Birthday'),
            //CountrySelect::class => Yii::t('UserModule.models_ProfileFieldType', 'Country'),
            MarkdownEditor::class => Yii::t('UserModule.models_ProfileFieldType', 'Markdown'),
            //Checkbox::class => Yii::t('UserModule.models_ProfileFieldType', 'Checkbox'),
            //CheckboxList::class => Yii::t('UserModule.models_ProfileFieldType', 'Checkbox List'),
        ), $this->fieldTypes);
        return $fieldTypes;
    }

    public function getTypeInstances($profileField = null)
    {

        $types = array();
        foreach ($this->getFieldTypes() as $className => $title) {
            if (Helpers::CheckClassType($className, self::class)) {
                $instance = new $className;
                if ($profileField != null) {
                    $instance->profileField = $profileField;


                    // Seems current type, so try load data
                    if ($profileField->field_type_class == $className) {
                        $instance->loadFieldConfig();
                    }
                }
                $types[] = $instance;
            }
        }
        return $types;
    }

    /**
     * Return the Form Element to edit the value of the Field
     */
    public function getFieldFormDefinition()
    {

        $definition = array($this->profileField->internal_name => [
            'type' => 'text',
            'class' => 'form-control',
            'readonly' => (!$this->profileField->editable)
        ]);

        return $definition;
    }

    /**
     * Returns the Edit Form for administrators this Field Type.
     *
     * This method should be overwritten by the file type class.
     *
     * @param type $definition
     * @return Array of Form Definition
     */
    public function getFormDefinition($definition = array())
    {

        $definition[get_class($this)]['class'] = "fieldTypeSettings " . str_replace("\\", "_", get_class($this));
        return $definition;
    }

    /**
     * Validates a ProfileFieldType
     *
     * This is only necessary when its linked to a profileField and the profiletype
     * has the current type of profilefieldtype
     *
     * @return boolean
     */
    public function validate($attributes = null, $clearErrors = true)
    {

        // Bound to a profile field?
        if ($this->profileField != null) {
            // Current Profile Field matches the selected profile field
            if ($this->profileField->field_type_class == get_class($this)) {
                return parent::validate($attributes, $clearErrors);
            }
        }

        return true;
    }

    /**
     * Saves the profile field type
     *
     * The settings/configuration for a ProfileFieldType are saved in ProfileField
     * in attribute "field_type_config" as JSON data.
     *
     * The ProfileFieldType Class itself can overwrite this behavior.
     */
    public function save()
    {

        $data = array();

        foreach ($this->attributes as $attributeName => $value) {
            // Dont save profile field attribute
            if ($attributeName == 'profileField')
                continue;

            $data[$attributeName] = $this->$attributeName;
        }
        $this->profileField->field_type_config = \yii\helpers\Json::encode($data);

        if (!$this->profileField->save()) {
            throw new \yii\base\Exception("Could not save profile field!");
        }
        // Clear Database Schema
        Yii::$app->getDb()->getSchema()->getTableSchema(Profile::tableName(), true);

        return true;
    }

    /**
     * Loads the profile field type settings
     *
     * These settings are loaded from the underlying ProfileField.
     */
    public function loadFieldConfig()
    {
        if ($this->profileField->field_type_config == '') {
            return;
        }

        $config = \yii\helpers\Json::decode($this->profileField->field_type_config);
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                if (property_exists($this, $key))
                    $this->$key = $value;
            }
        }
    }

    /**
     * Deletes a Profile Field Type
     */
    public function delete()
    {
        $columnName = $this->profileField->internal_name;
        if (Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->dropColumn(Profile::tableName(), $this->profileField->internal_name);
            Yii::$app->db->createCommand($query)->execute();
        } else {
            Yii::error('Could not delete profile column - not exists!');
        }
    }

    /**
     * Adds the new profile type to the profile table.
     *
     * This method should be overwritten by the child class.
     */
    public function addToProfileTable()
    {
        return true;
    }

    /**
     * Returns validation rules for field type.
     * The inherited field type class should pass his rules to this method.
     *
     * @param type $rules
     * @return Array rules
     */
    public function getFieldRules($rules = array())
    {

        if ($this->profileField->required)
            $rules[] = array($this->profileField->internal_name, 'required');


        return $rules;
    }

    /**
     * Returns the value of a given user of this field
     *
     * @param type $user
     * @param type $raw
     * @return type
     */
    public function getUserValue($user, $raw = true)
    {
        $internalName = $this->profileField->internal_name;

        if ($raw) {
            return $user->profile->$internalName;
        } else {
            return \yii\helpers\Html::encode($user->profile->$internalName);
        }
    }

    public function getLabels()
    {
        $labels = array();
        $labels[$this->profileField->internal_name] = Yii::t($this->profileField->getTranslationCategory(), $this->profileField->title);
        return $labels;
    }

    public function addFieldType($fieldClass, $title)
    {
        $this->fieldTypes[$fieldClass] = $title;
    }

    /**
     * This method is called before the field value is stored in Profile table.
     *
     * @param string $value
     * @return string modified value
     */
    public function beforeProfileSave($value)
    {
        if ($value == "") {
            return null;
        }

        return $value;
    }

    /**
     * Load field type default settings to the profile
     *
     * @param Profile $profile
     */
    public function loadDefaults(Profile $profile)
    {

    }

}
