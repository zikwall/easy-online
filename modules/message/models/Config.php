<?php

namespace zikwall\easyonline\modules\message\models;

use DateInterval;
use DateTime;
use zikwall\easyonline\modules\user\models\User;
use Yii;
use zikwall\easyonline\modules\message\Module;

class Config extends \yii\base\Model
{
    public $showInTopNav;

    public $newUserRestrictionEnabled = 0;

    public $newUserSinceDays = 3;

    public $newUserConversationRestriction = 2;

    public $newUserMessageRestriction = 5;

    public $userConversationRestriction = 15;

    public $userMessageRestriction = null;

    public function init()
    {
        parent::init();
        $module = $this->getModule();
        $this->showInTopNav = !$module->showInTopNav();
        $this->newUserRestrictionEnabled = (int) $module->settings->get('newUserRestrictionEnabled', $this->newUserRestrictionEnabled);
        $this->newUserSinceDays = (int) $module->settings->get('newUserSinceDays', $this->newUserSinceDays);
        $this->newUserConversationRestriction = (int) $module->settings->get('newUserConversationRestriction', $this->newUserConversationRestriction);
        $this->newUserMessageRestriction = (int) $module->settings->get('newUserMessageRestriction', $this->newUserMessageRestriction);
        $this->userConversationRestriction = (int) $module->settings->get('userConversationRestriction', $this->userConversationRestriction);
        $this->userMessageRestriction = (int) $module->settings->get('userMessageRestriction', $this->userMessageRestriction);
    }

    /**
     * @return Module
     */
    public static function getModule()
    {
        return Yii::$app->getModule('message');
    }

    public function rules()
    {
        return [
            [['showInTopNav', 'newUserRestrictionEnabled'], 'boolean'],
            [['newUserConversationRestriction',
                'newUserMessageRestriction',
                'userConversationRestriction',
                'userMessageRestriction'], 'integer', 'min' => 0],
            ['newUserSinceDays', 'integer', 'min' => 1]
        ];
    }

    public function attributeLabels()
    {
        return [
            'showInTopNav' => Yii::t('MessageModule.base', 'Show menu item in top Navigation'),
            'newUserRestrictionEnabled' => Yii::t('MessageModule.base', 'Seperate restrictions for new users'),
            'newUserSinceDays' => Yii::t('MessageModule.base', 'Until a user is member since (days)'),
            'newUserConversationRestriction' => Yii::t('MessageModule.base', 'Max number of new conversations allowed for a new user per day'),
            'newUserMessageRestriction' => Yii::t('MessageModule.base', 'Max number of messages allowed for a new user per day'),
            'userConversationRestriction' => Yii::t('MessageModule.base', 'Max number of new conversations allowed for a user per day'),
            'userMessageRestriction' => Yii::t('MessageModule.base', 'Max messages allowed per day')
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $module = static::getModule();
        $module->settings->set('showInTopNav', $this->showInTopNav);
        $module->settings->set('newUserRestrictionEnabled', $this->newUserRestrictionEnabled);
        $module->settings->set('newUserSinceDays', $this->newUserSinceDays);
        $module->settings->set('newUserConversationRestriction', $this->newUserConversationRestriction);
        $module->settings->set('newUserMessageRestriction', $this->newUserMessageRestriction);
        $module->settings->set('userConversationRestriction', $this->userConversationRestriction);
        $module->settings->set('userMessageRestriction', $this->userMessageRestriction);
        return true;
    }

    public function canCreateConversation(User $originator)
    {
        if ($originator->isSystemAdmin()) {
            return true;
        }

        $maxConversations = $this->isNewUser($originator)
            ? $this->newUserConversationRestriction
            : $this->userConversationRestriction;

        return $maxConversations === null || $this->getConversationCount($originator) < $maxConversations;
    }

    public function isNewUser(User $originator)
    {
        if (!$this->newUserRestrictionEnabled) {
            return false;
        }

       return (new DateTime($originator->created_at))->diff(new DateTime())->days < $this->newUserSinceDays;
    }

    public function getConversationCount($originator)
    {
        $module = static::getModule();
        $lastTS = $module->settings->contentContainer($originator)->get('conversationCountTime');

        if (!$lastTS) {
            $module->settings->contentContainer($originator)->set('conversationCountTime', time());
            $module->settings->contentContainer($originator)->set('conversationCount', 0);
            return 0;
        }

        $lastDate = (new \DateTime())->setTimestamp($lastTS);
        $today = (new \DateTime())->setTime(0,0,0);

        if ($today > $lastDate) {
            $module->settings->contentContainer($originator)->set('conversationCountTime', time());
            $module->settings->contentContainer($originator)->set('conversationCount', 0);
            return 0;
        }

        return (integer) static::getModule()->settings->contentContainer($originator)->get('conversationCount', 0);
    }

    public function reset($originator)
    {
        $module = static::getModule();
        $module->settings->contentContainer($originator)->set('conversationCountTime', null);
        $module->settings->contentContainer($originator)->set('conversationCount', null);
    }

    public function incrementConversationCount($originator)
    {
        static::getModule()->settings->contentContainer($originator)->set('conversationCount', ($this->getConversationCount($originator) + 1));
    }
}
