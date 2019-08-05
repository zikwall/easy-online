<?php

namespace zikwall\easyonline\modules\installer\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\base\Exception;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\Password;
use zikwall\easyonline\modules\user\models\Group;
use zikwall\easyonline\modules\installer\libs\InitialData;
use zikwall\easyonline\modules\core\libs\UUID;

class InstallController extends Controller
{

    public function actionAuto()
    {
        $this->stdout("Install:\n\n", Console::FG_YELLOW);

        InitialData::bootstrap();

        Yii::$app->settings->set('name', 'EasyOnline Test');
        Yii::$app->settings->set('mailer.systemEmailName', 'humhub@example.com');
        Yii::$app->settings->set('mailer.systemEmailName', 'humhub@example.com');
        Yii::$app->settings->set('secret', UUID::v4());

        $user = new User();
        //$user->group_id = 1;
        $user->username = 'Admin';
        $user->email = 'humhub@example.com';
        $user->status = User::STATUS_ENABLED;
        $user->language = '';
        if (!$user->save()) {
            throw new Exception("Could not save user");
        }

        $user->profile->title = 'System Administration';
        $user->profile->firstname = 'John';
        $user->profile->lastname = 'Doe';
        $user->profile->save();

        $password = new Password();
        $password->user_id = $user->id;
        $password->setPassword('test');
        $password->save();

        // Assign to system admin group
        Group::getAdminGroup()->addUser($user);

        return ExitCode::OK;
    }

}
