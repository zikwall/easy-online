<?php

namespace zikwall\easyonline\modules\core\models;

/**
 * @property integer $id
 * @property string $module_id
 * @property integer $contentcontainer_id
 * @property string $name
 * @property string $value
 * @property User $contentcontainer
 */

use zikwall\easyonline\modules\user\models\User;

class ContentContainerSetting extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contentcontainer_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id', 'contentcontainer_id', 'name'], 'required'],
            [['contentcontainer_id'], 'integer'],
            [['value'], 'string'],
            [['module_id', 'name'], 'string', 'max' => 50],
            [['module_id', 'contentcontainer_id', 'name'], 'unique', 'targetAttribute' => ['module_id', 'contentcontainer_id', 'name'], 'message' => 'The combination of Module ID, Contentcontainer ID and Name has already been taken.'],
            [['contentcontainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['contentcontainer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'contentcontainer_id' => 'Contentcontainer ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentcontainer()
    {
        return $this->hasOne(User::class, ['id' => 'contentcontainer_id']);
    }

}
