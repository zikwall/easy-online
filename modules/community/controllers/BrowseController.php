<?php


namespace zikwall\easyonline\modules\community\controllers;

use Yii;
use zikwall\easyonline\components\Controller;

/**
 * BrowseController
 *
 * @author Luke
 * @package humhub.modules_core.community.controllers
 * @since 0.5
 */
class BrowseController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \zikwall\easyonline\components\behaviors\AccessControl::class,
                'guestAllowedActions' => ['search-json']
            ]
        ];
    }

    /**
     * Returns a workcommunity list by json
     *
     * It can be filtered by by keyword.
     */
    public function actionSearchJson()
    {
        \Yii::$app->response->format = 'json';

        $keyword = Yii::$app->request->get('keyword', "");
        $page = (int) Yii::$app->request->get('page', 1);
        $limit = (int) Yii::$app->request->get('limit', Yii::$app->settings->get('paginationSize'));

        $searchResultSet = Yii::$app->search->find($keyword, [
            'model' => \zikwall\easyonline\modules\community\models\Community::class,
            'page' => $page,
            'pageSize' => $limit
        ]);

        return $this->prepareResult($searchResultSet);
    }

    protected function prepareResult($searchResultSet)
    {
        $target = Yii::$app->request->get('target');

        $json = [];
        $withChooserItem = ($target === 'chooser');
        foreach ($searchResultSet->getResultInstances() as $community) {
            $json[] = \zikwall\easyonline\modules\community\widgets\Chooser::getCommunityResult($community, $withChooserItem);
        }

        return $json;
    }

}
