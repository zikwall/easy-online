<?php

namespace zikwall\easyonline\modules\community\controllers\type;

use Yii;
use zikwall\easyonline\modules\community\controllers\CreateController;
use zikwall\easyonline\modules\community\models\Type;

class CreateSpaceController extends CreateController
{
    /**
     * @inheritdoc
     */
    protected function createSpaceModel()
    {
        $type = Type::findOne(['id' => Yii::$app->request->get('type_id')]);
        if ($type === null) {
            throw new \yii\base\Exception("Could not find space type!");
        }

        if (!$type->canCreateSpace()) {
            throw new \yii\base\Exception("Insuffient permissions!");
        }


        $model = parent::createCommunityModel();
        $model->community_type_id = $type->id;
        return $model;
    }

    public function getTypeTitle($model)
    {
        $type = Type::findOne(['id' => $model->community_type_id]);
        if ($type !== null) {
            return $type->item_title;
        }

        return "undefined";
    }

}
