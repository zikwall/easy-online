<?php

namespace zikwall\easyonline\modules\admin\controllers;

use Yii;
use zikwall\easyonline\modules\ {
    admin\components\Controller,
    admin\permissions\SeeAdminInformation,
    core\helpers\TestHelper
};

class InformationController extends Controller
{
    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'about';

    public function init()
    {
        $this->subLayout = '@admin/views/layouts/information';
        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => SeeAdminInformation::class]
        ];
    }

    public function actionAbout()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'About'));
        $isNewVersionAvailable = false;
        $isUpToDate = false;


        return $this->render('about', [
            'currentVersion' => Yii::$app->version,
            'latestVersion' => 1,
            'isNewVersionAvailable' => $isNewVersionAvailable,
            'isUpToDate' => $isUpToDate
        ]);
    }

    public function actionPrerequisites()
    {
        return $this->render('prerequisites', ['checks' => TestHelper::getResults()]);
    }

    public function actionCronjobs()
    {
        $currentUser = '';
        if (function_exists('get_current_user')) {
            $currentUser = get_current_user();
        }

        $lastRunHourly = Yii::$app->settings->getUncached('cronLastHourlyRun');
        $lastRunDaily = Yii::$app->settings->getUncached('cronLastDailyRun');


        return $this->render('cronjobs', [
            'lastRunHourly' => $lastRunHourly,
            'lastRunDaily' => $lastRunDaily,
            'currentUser' => $currentUser
        ]);
    }

}
