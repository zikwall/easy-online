<?php

namespace zikwall\easyonline\modules\installer\libs;

use Yii;
use yii\base\Exception;
use zikwall\easyonline\modules\user\models\ProfileFieldCategory;
use zikwall\easyonline\modules\user\models\ProfileField;
use zikwall\easyonline\modules\user\models\Group;

class InitialData
{
    public static function bootstrap()
    {
        // Seems database is already initialized
        if (Yii::$app->settings->get('paginationSize') == 10) {
            return;
        }

        Yii::$app->settings->set('baseUrl', \yii\helpers\BaseUrl::base(true));
        Yii::$app->settings->set('paginationSize', 10);
        Yii::$app->settings->set('displayNameFormat', '{profile.firstname} {profile.lastname}');
        Yii::$app->settings->set('horImageScrollOnMobile', true);

        // Avoid immediate cron run after installation
        Yii::$app->settings->set('cronLastDailyRun', time());

        // Authentication
        Yii::$app->getModule('user')->settings->set('auth.needApproval', '0');
        Yii::$app->getModule('user')->settings->set('auth.anonymousRegistration', '1');
        Yii::$app->getModule('user')->settings->set('auth.internalUsersCanInvite', '1');

        // Mailing
        Yii::$app->settings->set('mailer.transportType', 'php');
        Yii::$app->settings->set('mailer.systemEmailAddress', 'social@example.com');
        Yii::$app->settings->set('mailer.systemEmailName', 'My Social Network');
        //Yii::$app->getModule('activity')->settings->set('mailSummaryInterval', \zikwall\easyonline\modules\activity\components\MailSummary::INTERVAL_DAILY);

        // Caching
        Yii::$app->settings->set('cache.class', 'yii\caching\FileCache');
        Yii::$app->settings->set('cache.expireTime', '3600');
        Yii::$app->getModule('admin')->settings->set('installationId', md5(uniqid("", true)));

        // Design
        Yii::$app->getModule('community')->settings->set('communityOrder', 0);

        // Basic
        //Yii::$app->getModule('tour')->settings->set('enable', 1);
        Yii::$app->settings->set('defaultLanguage', Yii::$app->language);

        // Notification
        //Yii::$app->getModule('notification')->settings->set('enable_html5_desktop_notifications', 0);

        // Avoid warning direct after installation
        Yii::$app->settings->set('cronLastRun', time());
    }

}
