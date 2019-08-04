<?php



namespace zikwall\easyonline\modules\community\widgets;

use zikwall\easyonline\modules\core\components\base\Widget;

class MembershipButton extends Widget
{

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $membership = $this->community->getMembership();

        return $this->render('membershipButton', [
            'community' => $this->community,
            'membership' => $membership
        ]);
    }

}
