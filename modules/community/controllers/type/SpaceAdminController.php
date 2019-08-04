<?php

namespace zikwall\easyonline\modules\community\controllers\type;

use Yii;
use yii\base\Event;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\community\modules\manage\widgets\Menu;
use zikwall\easyonline\modules\community\models\Type;

class SpaceAdminController extends ContentContainerController
{

    public $hideSidebar = true;

    public function beforeAction($action)
    {
        if (!$this->contentContainer->isAdmin()) {
            throw new \yii\web\HttpException(403, 'Access denied!');
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        // Highlight correct menu item
        Event::on(Menu::class, Menu::EVENT_INIT, function ($event) {
            if ($event->sender->space->id == $this->contentContainer->id) {
                $event->sender->markAsActive($this->contentContainer->createUrl('/space/manage'));
            }
        });

        $spaceTypes = \yii\helpers\ArrayHelper::map(Type::find()->all(), 'id', 'item_title');

        $model = Community::findOne(['id' => $this->contentContainer->id]);
        $model->scenario = 'changeType';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updateAttributes(['community_type_id' => $model->community_type_id]);
            Yii::$app->search->update(Community::findOne(['id' => $this->contentContainer->id]));

            Yii::$app->getSession()->setFlash('data-saved', Yii::t('base', 'Saved'));
            return $this->redirect($model->createUrl('index'));
        }

        return $this->render('index', ['community' => $this->contentContainer, 'model' => $model, 'communityTypes' => $spaceTypes]);
    }

    public function actionImage()
    {
        return $this->render('image', ['community' => $this->contentContainer]);
    }

}
