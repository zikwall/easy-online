<?php

namespace zikwall\easyonline\modules\community\controllers\type;

use Yii;
use zikwall\easyonline\modules\directory\widgets\Sidebar;
use zikwall\easyonline\modules\community\models\Type;
use zikwall\easyonline\modules\core\models\Setting;


class DirectoryController extends \zikwall\easyonline\modules\directory\components\Controller
{

    public function actionIndex()
    {
        $spaceType = Type::findOne(['id' => Yii::$app->request->get('id'), 'show_in_directory' => 1]);

        if ($spaceType === null) {
            throw new \yii\web\HttpException(404, 'Could not find space type!');
        }

        $pageSize = Setting::Get('paginationSize');
        if (property_exists(Yii::$app->getModule('directory'), 'pageSize')) {
            $pageSize = Yii::$app->getModule('directory')->pageSize;
        }

        $keyword = Yii::$app->request->get('keyword', "");
        $page = (int) Yii::$app->request->get('page', 1);

        $searchResultSet = Yii::$app->search->find($keyword, [
            'model' => \humhub\modules\space\models\Space::class,
            'page' => $page,
            'sortField' => ($keyword == '') ? 'title' : null,
            'pageSize' => $pageSize,
            'filters' => [
                'type_id' => ($spaceType !== null) ? $spaceType->id : ''
            ]
        ]);

        $pagination = new \yii\data\Pagination(['totalCount' => $searchResultSet->total, 'pageSize' => $searchResultSet->pageSize]);

        \yii\base\Event::on(Sidebar::class, Sidebar::EVENT_INIT, function($event) {
            $event->sender->addWidget(\humhub\modules\directory\widgets\NewCommunities::class, [], ['sortOrder' => 10]);
            $event->sender->addWidget(\humhub\modules\directory\widgets\SpaceStatistics::class, [], ['sortOrder' => 20]);
        });

        return $this->render('index', array(
                    'keyword' => $keyword,
                    'spaces' => $searchResultSet->getResultInstances(),
                    'pagination' => $pagination,
                    'spaceType' => $spaceType
        ));
    }

}
