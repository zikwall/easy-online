<?php

namespace zikwall\easyonline\modules\content\models;

use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\components\ActiveRecord;

class ContentDeprecated extends ActiveRecord
{

    /**
     * User which created this Content
     * Note: Use createdBy attribute instead.
     *
     * @deprecated since version 1.1
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->createdBy;
    }

    /**
     * Return space (if this content assigned to a space)
     * Note: Use container attribute instead
     *
     * @deprecated since version 1.1
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        if ($this->getContainer() instanceof Space) {
            return $this->getContainer();
        }

        return null;
    }

    /**
     * Checks if the content can be deleted
     * Note: Use canEdit method instead.
     *
     * @deprecated since version 1.1
     * @param int $userId optional user id (if empty current user id will be used)
     */
    public function canDelete($userId = "")
    {
        return $this->canEdit(($userId !== '') ? User::findOne(['id' => $userId]) : null);
    }

    /**
     * Checks if this content can readed
     * Note: use canView method instead
     *
     * @deprecated since version 1.1
     * @param int $userId
     * @return boolean
     */
    public function canRead($userId = "")
    {
        return $this->canView(($userId !== '') ? User::findOne(['id' => $userId]) : null);
    }

    /**
     * Checks if this content can be changed
     * Note: use canEdit method instead
     *
     * @deprecated since version 1.1
     * @param int $userId
     * @return boolean
     */
    public function canWrite($userId = "")
    {
        return $this->canEdit(($userId !== '') ? User::findOne(['id' => $userId]) : null);
    }

}
