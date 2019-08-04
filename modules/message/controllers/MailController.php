<?php

namespace zikwall\easyonline\modules\message\controllers;

use zikwall\easyonline\modules\message\widgets\wall\ConversationEntry;
use Yii;
use zikwall\easyonline\modules\message\permissions\StartConversation;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\HttpException;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\message\models\Message;
use zikwall\easyonline\modules\message\models\MessageEntry;
use zikwall\easyonline\modules\message\models\UserMessage;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\message\models\forms\InviteParticipantForm;
use zikwall\easyonline\modules\message\models\forms\ReplyForm;
use zikwall\easyonline\modules\message\models\forms\CreateMessage;
use zikwall\easyonline\modules\message\permissions\SendMail;
use zikwall\easyonline\modules\user\models\UserPicker;

class MailController extends Controller
{
    public $pageSize = 5;

    public function getAccessRules()
    {
        return [
            ['login'],
            ['permission' => StartConversation::class, 'actions' => ['create', 'add-user']]
        ];
    }

    public function actionIndex($id = null)
    {
        $query = UserMessage::getByUser();

        $countQuery = clone $query;
        $messageCount = $countQuery->count();
        $pagination = new Pagination(['totalCount' => $messageCount, 'pageSize' => $this->pageSize]);

        $query->offset($pagination->offset)->limit($pagination->limit);
        $userMessages = $query->all();

        // If no messageId is given, use first if available
        if ((!$id || !$this->getMessage($id)) && $messageCount) {
            $id = $userMessages[0]->message->id;
        }

        return $this->render('index', [
            'messageId' => $id,
            'userMessages' => $userMessages,
            'pagination' => $pagination
        ]);
    }

    /**
     * Shows a Message Thread
     */
    public function actionShow($id)
    {
        $message = ($id instanceof Message) ? $id : $this->getMessage($id);

        $this->checkMessagePermissions($message);

        // Marks message as seen
        $message->seen(Yii::$app->user->id);

        return $this->renderAjax('conversation', [
            'message' => $message,
            'messageCount' => UserMessage::getNewMessageCount(),
            'replyForm' => new ReplyForm(['model' => $message]),
        ]);
    }

    public function actionSeen()
    {
        $id = Yii::$app->request->post('id');

        if ($id) {
            $message = ($id instanceof Message) ? $id : $this->getMessage($id);
            $this->checkMessagePermissions($message);
            $message->seen(Yii::$app->user->id);
        }

        return $this->asJson([
            'messageCount' => UserMessage::getNewMessageCount()
        ]);
    }

    public function actionUpdate($id, $from = null)
    {
        $message = ($id instanceof Message) ? $id : $this->getMessage($id);

        $this->checkMessagePermissions($message);

        $entries = $message->getEntries($from)->all();

        $result = '';
        foreach ($entries as $entry) {
            $result .= ConversationEntry::widget(['entry' => $entry]);
        }

        return $this->renderAjaxContent($result);
    }

    public function actionReply($id)
    {
        $message = $this->getMessage($id);

        $this->checkMessagePermissions($message);

        // Reply Form
        $replyForm = new ReplyForm(['model' => $message]);
        if ($replyForm->load(Yii::$app->request->post()) && $replyForm->save()) {
            return $this->asJson([
                'success' => true,
                'content' => ConversationEntry::widget(['entry' => $replyForm->reply])
            ]);
        }

        return $this->asJson([
            'success' => false,
            'error' => [
                'message' => $replyForm->getFirstError('message')
            ]
        ]);
    }

    public function actionAddUser($id)
    {
        $message = $this->getMessage($id);

        $this->checkMessagePermissions($message);

        // Invite Form
        $inviteForm = new InviteParticipantForm(['message' => $message]);

        if ($inviteForm->load(Yii::$app->request->post())) {
            if ($inviteForm->save()) {
                return $this->actionShow($message->id);
            } else {
                return $this->asJson([
                    'success' => false,
                    'error' => [
                        'message' => $inviteForm->getFirstError('recipients')
                    ]
                ]);

            }
        }

        return $this->renderAjax('adduser', ['inviteForm' => $inviteForm]);
    }

    public function actionNotificationList()
    {
        $query = UserMessage::getByUser(null, 'message.updated_at DESC')->limit(5);
        return $this->renderAjax('notificationList', ['userMessages' => $query->all()]);
    }

    public function actionSearchUser($id = null, $keyword)
    {
        /*$subQuery = UserMessage::find()->where('user_message.user_id = user.id')->andWhere(['user_message.message_id' => $id]);
        $query = User::find()->where(['NOT EXISTS', $subQuery]);
        $fillQuery = User::find()->where(['EXISTS', $subQuery]);*/

        $message = $this->getMessage($id);

        if ($message) {
            $this->checkMessagePermissions($message);
        }

        $result = UserPicker::filter([
            'query' => User::find(),
            'keyword' => $keyword,
            'permission' => (!Yii::$app->user->isAdmin()) ? new SendMail() : null,
            'fillUser' => true,
            'disableFillUser' => true,
            'disabledText' => Yii::t('MessageModule.base','You are not allowed to start a conversation with this user.')
        ]);

        //Disable already participating users
        if ($message) {
            foreach($result as $i=>$user) {
                if ($this->isParticipant($message, $user)) {
                    $index = $i++;
                    $result[$index]['disabled'] = true;
                    $result[$index]['disabledText'] = Yii::t('MessageModule.base','This user is already participating in this conversation.');
                }
            }
        }

        return $this->asJson($result);
    }

    private function checkMessagePermissions($message)
    {
        if ($message == null) {
            throw new HttpException(404, 'Could not find message!');
        }

        if (!$message->isParticipant(Yii::$app->user->getIdentity())) {
            throw new HttpException(403, 'Access denied!');
        }
    }

    private function isParticipant($message, $user) {
        foreach($message->users as $participant) {
            if ($participant->guid === $user['guid']) {
                return true;
            }
        }
        return false;
    }

    public function actionCreate()
    {
        $userGuid = Yii::$app->request->get('userGuid');
        $model = new CreateMessage();
        
        // Preselect user if userGuid is given
        if ($userGuid != "") {
            $user = User::findOne(['guid' => $userGuid]);
            if (isset($user) && (version_compare(Yii::$app->version, '1.1', 'lt') || $user->getPermissionManager()->can(new SendMail()) 
                    || (!Yii::$app->user->isGuest && Yii::$app->user->isAdmin()))) {
                $model->recipient = $user->guid;
            }
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->htmlRedirect(['index', 'id' => $model->messageInstance->id]);
        }
        
        return $this->renderAjax('create', ['model' => $model]);
    }

    public function actionLeave($id)
    {
        $this->forcePostRequest();
        
        $message = $this->getMessage($id);

        if (!$message) {
            throw new HttpException(404, 'Could not find message!');
        }

        $message->leave(Yii::$app->user->id);

        return $this->asJson([
            'success' => true,
            'redirect' => Url::to(['/mail/mail/index'])
        ]);
    }

    public function actionEditEntry($id)
    {
        $entry = MessageEntry::findOne(['id' => $id]);

        if (!$entry) {
            throw new HttpException(404);
        }

        if (!$entry->canEdit()) {
            throw new HttpException(403);
        }

        if ($entry->load(Yii::$app->request->post()) && $entry->save()) {
            $entry->fileManager->attach( Yii::$app->request->post('fileList'));
            return $this->asJson([
                'success' => true,
                'content' => ConversationEntry::widget(['entry' => $entry])
            ]);
        }

        return $this->renderAjax('editEntry', ['entry' => $entry]);
    }

    public function actionDeleteEntry($id)
    {
        $this->forcePostRequest();
        $entry = MessageEntry::findOne(['id' => $id]);

        if (!$entry) {
            throw new HttpException(404);
        }

        // Check if message entry exists and it´s by this user
        if (!$entry->canEdit()) {
            throw new HttpException(403);
        }

        $entry->message->deleteEntry($entry);

        return $this->asJson([
            'success' => true
        ]);
    }

    public function actionGetNewMessageCountJson()
    {
        $json = ['newMessages' => UserMessage::getNewMessageCount()];
        return $this->asJson($json);
    }

    private function getMessage($id)
    {
        $message = Message::findOne(['id' => $id]);

        if ($message) {
            $userMessage = $message->getUserMessage();
            if ($userMessage != null) {
                return $message;
            }
        }

        return null;
    }
}
