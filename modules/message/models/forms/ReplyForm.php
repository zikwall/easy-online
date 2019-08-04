<?php

namespace zikwall\easyonline\modules\message\models\forms;

use zikwall\easyonline\modules\message\models\Message;
use zikwall\easyonline\modules\message\models\MessageEntry;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class ReplyForm extends Model
{
    /**
     * @var Message
     */
    public $model;

    /**
     * @var string
     */
    public $message;

    /**
     * @var MessageEntry
     */
    public $reply;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return [
            ['message', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => Yii::t('MessageModule.forms_ReplyMessageForm', 'Message'),
        ];
    }

    public function getUrl()
    {
        return Url::to(['/mail/mail/reply', 'id' => $this->model->id]);
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->reply = new MessageEntry([
            'message_id' => $this->model->id,
            'user_id' => Yii::$app->user->id,
            'content' => $this->message
        ]);

        if ($this->reply->save()) {
            $this->reply->notify();
            $this->reply->fileManager->attach(Yii::$app->request->post('fileUploaderHiddenGuidField'));
            return true;
        }

        return false;
    }

}
