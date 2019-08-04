<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\web\HttpException;
use zikwall\easyonline\modules\core\libs\Helpers;
use zikwall\easyonline\modules\ui\widgets\ContentModalDialog;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\Password;
use zikwall\easyonline\modules\user\models\forms\AccountRecoverPassword;

class PasswordRecoveryController extends \zikwall\easyonline\modules\core\components\base\Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "@zikwall/easyonline/modules/user/views/layouts/login";

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new AccountRecoverPassword();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->recover()) {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('success_modal', [
                    'model' => $model
                ]);
            }
            return $this->render('success', [
                'model' => $model
            ]);
        }

        if (Yii::$app->request->isAjax) {
            return ContentModalDialog::widget([
                'content' => $this->renderAjax('index_modal', [
                    'model' => $model
                ]),
                'title' => Yii::t('UserModule.views_auth_recoverPassword', '<strong>Password</strong> recovery')
            ]);
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionReset()
    {
        $user = User::findOne(['guid' => Yii::$app->request->get('guid')]);

        if ($user === null) {
            throw new HttpException('500', 'It looks like you clicked on an invalid password reset link. Please try again.');
        }

        $model = new Password();
        $model->scenario = 'registration';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->getModule('user')->settings->contentContainer($user)->delete('passwordRecoveryToken');
            $model->user_id = $user->id;
            $model->setPassword($model->newPassword);
            $model->save();
            return $this->render('reset_success');
        }

        return $this->render('reset', [
            'model' => $model
        ]);
    }

    private function checkPasswordResetToken($user, $token)
    {
        // Сохраненный токен - Формат: randomToken.generationTime
        $savedTokenInfo = Yii::$app->getModule('user')->settings->contentContainer($user)->get('passwordRecoveryToken');

        if ($savedTokenInfo) {
            list($generatedToken, $generationTime) = explode('.', $savedTokenInfo);
            if (Helpers::same($generatedToken, $token)) {
                // Проверяем время генерации
                if ($generationTime + (24 * 60 * 60) >= time()) {
                    return true;
                }
            }
        }

        return false;
    }

}

