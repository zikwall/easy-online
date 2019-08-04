<?php

namespace zikwall\easyonline\modules\user\models\fieldtype;

use Yii;
use zikwall\easyonline\modules\core\libs\DbDateValidator;
use zikwall\easyonline\modules\user\models\Profile;

/**
 * Date Field
 *
 * @since 1.0.0-beta.4
 */
class Date extends BaseType
{

    /**
     * @inheritdoc
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(Profile::tableName(), $columnName, 'DATE');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * @inheritdoc
     */
    public function getFieldRules($rules = array())
    {
        $rules[] = [
            $this->profileField->internal_name,
            DbDateValidator::class,
            'format' => Yii::$app->formatter->dateInputFormat,
            'convertToFormat' => 'Y-m-d',
        ];
        return parent::getFieldRules($rules);
    }
    
    /**
     * @inheritdoc
     */
    public function getFormDefinition($definition = array())
    {
        return count($definition) > 0 ? parent::getFormDefinition($definition) : [];
    } 

    /**
     * @inheritdoc
     */
    public function getFieldFormDefinition()
    {
        return array($this->profileField->internal_name => array(
                'type' => 'datetime',
                'format' => Yii::$app->formatter->dateInputFormat,
                'class' => 'form-control',
                'readonly' => (!$this->profileField->editable),
                'dateTimePickerOptions' => array(
                    'pickTime' => false
                )
        ));
    }

    /**
     * @inheritdoc
     */
    public function getUserValue($user, $raw = true)
    {
        $internalName = $this->profileField->internal_name;
        $date = $user->profile->$internalName;

        if ($date == "" || $date == "0000-00-00")
            return "";

        return \yii\helpers\Html::encode($date);
    }

}

?>
