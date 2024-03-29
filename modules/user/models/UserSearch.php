<?php

namespace zikwall\easyonline\modules\user\models;

use zikwall\easyonline\modules\core\libs\DateHelper;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use zikwall\easyonline\modules\user\models\User;

class UserSearch extends User
{

    public $query;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['profile.firstname', 'profile.lastname']);
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'created_at', 'profile.firstname', 'profile.lastname', 'last_login'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ($this->query == null) ? User::find()->joinWith('profile') : $this->query;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'email',
            'last_login',
                'profile.firstname',
                'profile.lastname',
                'created_at',
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'user.id', $this->id]);
        $query->andFilterWhere(['like', 'user.username', $this->username]);
        $query->andFilterWhere(['like', 'user.email', $this->email]);
        $query->andFilterWhere(['like', 'profile.firstname', $this->getAttribute('profile.firstname')]);
        $query->andFilterWhere(['like', 'profile.lastname', $this->getAttribute('profile.lastname')]);

        if ($this->getAttribute('last_login') != "") {
            try {
                $last_login = DateHelper::parseDateTime($this->getAttribute('last_login'));

                $query->andWhere([
                    '=',
                    new \yii\db\Expression("DATE(last_login)"),
                    new \yii\db\Expression("DATE(:last_login)", [':last_login'=>$last_login])
                    ]);
            } catch (InvalidParamException $e) {
                // do not change the query if the date is wrong formatted
            }
        }

        return $dataProvider;
    }

}
