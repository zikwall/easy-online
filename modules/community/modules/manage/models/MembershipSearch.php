<?php


namespace zikwall\easyonline\modules\community\modules\manage\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;
use zikwall\easyonline\modules\community\models\Membership;

/**
 * Description of GroupSearch
 *
 * @author luke
 */
class MembershipSearch extends Membership
{

    /**
     * @var int Status of members to display
     */
    public $status = Membership::STATUS_MEMBER;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['user.username', 'user.profile.firstname', 'user.profile.lastname']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status'], 'integer'],
            [['user.profile.firstname', 'user.profile.lastname', 'user.username', 'group_id'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Membership::find();
        $query->andWhere(['community_membership.status' => $this->status]);
        $query->joinWith(['user', 'user.profile']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 50],
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'user.profile.firstname' => [
                    'asc' => ['profile.firstname' => SORT_ASC],
                    'desc' => ['profile.firstname' => SORT_DESC],
                ],
                'user.profile.lastname' => [
                    'asc' => ['profile.lastname' => SORT_ASC],
                    'desc' => ['profile.lastname' => SORT_DESC],
                ],
                'user.username',
                'last_visit',
                'group_id',
        ]]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andWhere(['community_membership.community_id' => $this->community_id]);

        $query->andFilterWhere(['community_membership.group_id' => $this->group_id]);
        $query->andFilterWhere(['like', 'profile.lastname', $this->getAttribute('user.profile.lastname')]);
        $query->andFilterWhere(['like', 'profile.firstname', $this->getAttribute('user.profile.firstname')]);
        $query->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

        return $dataProvider;
    }

}
