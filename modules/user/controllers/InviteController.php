<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\web\Controller;
use zikwall\easyonline\modules\core\behaviors\AccessControl;
use zikwall\easyonline\modules\core\widgets\ModalClose;
use zikwall\easyonline\modules\ui\widgets\ContentModalDialog;
use zikwall\easyonline\modules\user\models\Invite;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\permissions\ManageUsers;

class InviteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
            ]
        ];
    }

    public function actionIndex()
    {
        if (!$this->canInvite()) {
            throw new \yii\web\HttpException(403, 'Invite denied!');
        }

        $model = new \zikwall\easyonline\modules\user\models\forms\Invite();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach ($model->getEmails() as $email) {
                $this->createInvite($email);
            }

            return ContentModalDialog::widget([
                'content' =>  Yii::t('UserModule.user', 'User has been invited.'),
                'title' => 'Уведомление'
            ]);
        }

        return ContentModalDialog::widget([
            'content' => $this->renderAjax('index', ['model' => $model]),
            'title' => Yii::t('UserModule.invite', '<strong>Invite</strong> new people')
        ]);
    }

    /**
     * Creates and sends an e-mail invite
     * 
     * @param string $email
     */
    protected function createInvite($email)
    {
        $userInvite = new Invite();
        $userInvite->email = $email;
        $userInvite->source = Invite::SOURCE_INVITE;
        $userInvite->user_originator_id = Yii::$app->user->getIdentity()->id;
        
        $existingInvite = Invite::findOne(['email' => $email]);
        if ($existingInvite !== null) {
            $userInvite->token = $existingInvite->token;
            $existingInvite->delete();
        }
        
        $userInvite->save();
        $userInvite->sendInviteMail();
    }

    /**
     * Checks if current user can invite new members
     * 
     * @return boolean can invite new members
     */
    protected function canInvite()
    {
        return Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite') || Yii::$app->user->can([
            new ManageUsers(),
            new ManageGroups()
        ]);
    }

}

?>
