<?php

namespace zikwall\easyonline\modules\community\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use zikwall\easyonline\modules\community\models\Community;

class CommunitySearch extends Community
{
    public function rules()
    {
        return [
            [['id', 'visibility', 'join_policy'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Community::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'visibility',
                'join_policy',
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['join_policy' => $this->join_policy]);
        $query->andFilterWhere(['visibility' => $this->visibility]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
