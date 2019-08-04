<?php

namespace zikwall\easyonline\modules\community\models;

use Yii;
use zikwall\easyonline\modules\community\models\Community;

/**
 * @inheritdoc
 */
class CommunityType extends Community
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['changeType'] = ['community_type_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [['community_type_id', 'integer']]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'community_type_id' => Yii::t('CommunityModule.communityType', 'Type'),
        ]);
    }

}
