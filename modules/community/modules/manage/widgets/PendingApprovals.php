<?php


namespace zikwall\easyonline\modules\community\modules\manage\widgets;


use \yii\base\Widget;

/**
 * PendingApprovals show open member approvals to admin in sidebar
 *
 * @author Luke
 * @since 0.21
 */
class PendingApprovals extends Widget
{

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    /**
     * @var int number of applicants to show
     */
    public $maxApplicants = 15;

    /**
     * @inheritdoc
     */
    public function run()
    {
        // Only visible for admins
        if (!$this->community->isAdmin()) {
            return;
        }

        $applicants = $this->community->getApplicants()->limit($this->maxApplicants)->all();

        // No applicants
        if (count($applicants) === 0) {
            return;
        }

        return $this->render('pendingApprovals', ['applicants' => $applicants, 'community' => $this->community]);
    }

}

?>
