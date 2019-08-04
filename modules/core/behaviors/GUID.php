<?php

namespace zikwall\easyonline\modules\core\behaviors;

use zikwall\easyonline\modules\core\libs\UUID;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class GUID extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setGuid',
            ActiveRecord::EVENT_BEFORE_INSERT => 'setGuid',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'setGuid',
        ];
    }

    public function setGuid($event)
    {
        if ($this->owner->isNewRecord) {
            if ($this->owner->guid == "") {
                $this->owner->guid = UUID::v4();
            }
        }
    }
}
