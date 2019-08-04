<?php



namespace zikwall\easyonline\modules\community\modules\manage\models;

use Yii;
use yii\base\Model;
use zikwall\easyonline\modules\community\models\Membership;

/**
 * Form Model for community owner change
 *
 * @since 0.5
 */
class ChangeOwnerForm extends Model
{

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    /**
     * @var string owner id
     */
    public $ownerId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['ownerId', 'required'],
            ['ownerId', 'in', 'range' => array_keys($this->getNewOwnerArray())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ownerId' => Yii::t('CommunityModule.manage', 'Community owner'),
        ];
    }

    /**
     * Returns an array of all possible community owners
     * 
     * @return array containing the user id as key and display name as value
     */
    public function getNewOwnerArray()
    {
        $possibleOwners = [];

        $query = Membership::find()->joinWith(['user', 'user.profile'])->andWhere(['community_membership.group_id' => 'admin', 'community_membership.community_id' => $this->community->id]);
        foreach ($query->all() as $membership) {
            $possibleOwners[$membership->user->id] = $membership->user->displayName;
        }

        return $possibleOwners;
    }

}
