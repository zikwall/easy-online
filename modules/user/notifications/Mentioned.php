<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2017 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\notifications;

use Yii;
use yii\bootstrap\Html;
use zikwall\easyonline\modules\notification\components\BaseNotification;

/**
 * Mentioned Notification is fired to all users which are mentionied
 * in a ContentActiveRecord or ContentAddonActiveRecord
 */
class Mentioned extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $viewName = 'mentioned';

    /**
     * @inheritdoc
     */
    public $moduleId = 'user';

    /**
     * @inheritdoc
     */
    public function category()
    {
        return new MentionedNotificationCategory;
    }

    /**
     * @inheritdoc
     */
    public function getViewName()
    {
        if ($this->source instanceof \zikwall\easyonline\modules\comment\models\Comment) {
            return 'mentionedComment';
        }

        return 'mentioned';
    }

    /**
     * inheritdoc
     */
    public function send(\zikwall\easyonline\modules\user\models\User $user)
    {
        // Do additional access check here, because the mentioned user may have no access to the content
        if (!$this->source->content->canView($user)) {
            return;
        }

        return parent::send($user);
    }

    /**
     * inheritdoc
     */
    public function getMailSubject()
    {
        return Yii::t('UserModule.notification', "{displayName} just mentioned you in {contentTitle} \"{preview}\"", [
                    'displayName' => Html::encode($this->originator->displayName),
                    'contentTitle' => $this->getContentName(),
                    'preview' => $this->getContentPreview()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Yii::t('UserModule.notification', '{displayName} mentioned you in {contentTitle}.', array(
                    'displayName' => Html::tag('strong', Html::encode($this->originator->displayName)),
                    'contentTitle' => $this->getContentInfo($this->source)
        ));
    }

}

?>
