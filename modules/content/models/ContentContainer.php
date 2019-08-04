<?php

namespace zikwall\easyonline\modules\content\models;

use zikwall\easyonline\modules\core\behaviors\PolymorphicRelation;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;

/**
 *
 * @property integer $id
 * @property string $guid
 * @property string $class
 * @property integer $pk
 * @property integer $owner_user_id
 */
class ContentContainer extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contentcontainer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk', 'owner_user_id'], 'integer'],
            [['guid', 'class'], 'string', 'max' => 255],
            [['class', 'pk'], 'unique', 'targetAttribute' => ['class', 'pk'], 'message' => 'The combination of Class and Pk has already been taken.'],
            [['guid'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'class' => 'Class',
            'pk' => 'Pk',
            'owner_user_id' => 'Owner User ID',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => PolymorphicRelation::class,
                'mustBeInstanceOf' => [ContentContainerActiveRecord::class],
                'classAttribute' => 'class',
                'pkAttribute' => 'pk'
            ]
        ];
    }

}
