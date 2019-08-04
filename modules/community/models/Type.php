<?php

namespace zikwall\easyonline\modules\community\models;

use Yii;
use zikwall\easyonline\modules\community\permissions\CreateCommunityType;

class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%community_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'item_title', 'sort_key'], 'required'],
            [['sort_key', 'show_in_directory'], 'integer'],
            [['title', 'item_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('CommunityModule.models_Type', 'ID'),
            'title' => Yii::t('CommunityModule.models_Type', 'Title'),
            'item_title' => Yii::t('CommunityModule.models_Type', 'Item Title'),
            'sort_key' => Yii::t('CommunityModule.models_Type', 'Sortorder'),
            'show_in_directory' => Yii::t('CommunityModule.models_Type', 'Show In Directory'),
        ];
    }

    /**
     * Checks if current user can a space of this type
     */
    public function getCreateCommunityPermission()
    {
        $permission = Yii::createObject(CreateCommunityType::class);
        $permission->communityType = $this;
        return $permission;
    }

    public function canCreateSpace()
    {
        if (Yii::$app->user->isAdmin()) {
            return true;
        }
        return (Yii::$app->user->permissionManager->can($this->getCreateCommunityPermission()));
    }

}
