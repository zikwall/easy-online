<?php

namespace zikwall\easyonline\modules\community\models;

use Yii;

class CommunityTypeDelete extends \yii\base\Model
{
    public $community_type_id;

    public function rules()
    {
        return [
            ['community_type_id', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'community_type_id' => Yii::t('AdminModule.models_forms_communityTypeDelete', 'Space Type'),
        ];
    }

}
