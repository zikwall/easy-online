<?php

namespace zikwall\easyonline\modules\community\widgets;

use \yii\base\Widget;
use zikwall\easyonline\modules\community\models\Membership;
use yii\db\Expression;
use zikwall\easyonline\modules\community\models\Community;

class Members extends Widget
{
    /**
     * @var int maximum members to display
     */
    public $maxMembers = 23;

    /**
     * @var Community the community
     */
    public $community;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $users = $this->getUserQuery()->all();

        return $this->render('members', [
            'community' => $this->community,
            'maxMembers' => $this->maxMembers,
            'users' => $users,
            'showListButton' => (count($users) == $this->maxMembers),
            'urlMembersList' => $this->community->createUrl('/community/membership/members-list'),
            'privilegedUserIds' => $this->getPrivilegedUserIds(),
            'totalMemberCount' => Membership::getCommunityMembersQuery($this->community)->visible()->count()
        ]);
    }

    /**
     * Returns a query for members of this community
     *
     * @return \yii\db\ActiveQuery the query
     */
    protected function getUserQuery()
    {
        $query = Membership::getCommunityMembersQuery($this->community)->visible();
        $query->limit($this->maxMembers);
        $query->orderBy(new Expression('FIELD(community_membership.group_id, "' . Community::USERGROUP_OWNER . '", "' . Community::USERGROUP_MODERATOR . '", "' . Community::USERGROUP_MEMBER . '")'));
        return $query;
    }

    /**
     * Returns an array with a list of privileged user ids.
     *
     * @return array the user ids separated by priviledged group id.
     */
    protected function getPrivilegedUserIds()
    {
        $privilegedMembers = [Community::USERGROUP_OWNER => [], Community::USERGROUP_ADMIN => [], Community::USERGROUP_MODERATOR => []];

        $query = Membership::find()->where(['community_id' => $this->community->id]);
        $query->andWhere(['IN', 'group_id', [Community::USERGROUP_OWNER, Community::USERGROUP_ADMIN, Community::USERGROUP_MODERATOR]]);
        foreach ($query->all() as $membership) {
            if (isset($privilegedMembers[$membership->group_id])) {
                $privilegedMembers[$membership->group_id][] = $membership->user_id;
            }
        }

        // Add owner manually, since it's not handled as user group yet
        $privilegedMembers[Community::USERGROUP_OWNER][] = $this->community->created_by;

        return $privilegedMembers;
    }

}

?>
