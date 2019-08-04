<?php

namespace zikwall\easyonline\modules\community\modules\manage\controllers;

use Yii;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\modules\manage\models\AdvancedSettingsCommunity;
use zikwall\easyonline\modules\community\widgets\Chooser;
use zikwall\easyonline\modules\community\modules\manage\components\Controller;
use zikwall\easyonline\modules\community\modules\manage\models\DeleteForm;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        $result = parent::getAccessRules();
        $result[] = [
            'userGroup' => [Community::USERGROUP_OWNER], 'actions' => ['archive', 'unarchive', 'delete']
        ];
        return $result;
    }

    /**
     * General community settings
     */
    public function actionIndex()
    {
        $community = $this->contentContainer;
        $community->scenario = 'edit';

        if ($community->load(Yii::$app->request->post()) && $community->validate() && $community->save()) {
            $this->view->saved();
            return $this->redirect($community->createUrl('index'));
        }
        return $this->render('index', ['model' => $community]);
    }

    public function actionAdvanced()
    {
        $community = AdvancedSettingsCommunity::findOne(['id' => $this->contentContainer->id]);
        $community->scenario = 'edit';
        $community->indexUrl = Yii::$app->getModule('community')->settings->community()->get('indexUrl');
        $community->indexGuestUrl = Yii::$app->getModule('community')->settings->community()->get('indexGuestUrl');

        if ($community->load(Yii::$app->request->post()) && $community->validate() && $community->save()) {
            $this->view->saved();
            return $this->redirect($community->createUrl('advanced'));
        }

        $indexModuleSelection = \zikwall\easyonline\modules\community\widgets\Menu::getAvailablePages();

        //To avoid infinit redirects of actionIndex we remove the stream value and set an empty selection instead
        array_shift($indexModuleSelection);
        $indexModuleSelection = ["" => Yii::t('CommunityModule.controllers_AdminController', 'Stream (Default)')] + $indexModuleSelection;

        return $this->render('advanced', ['model' => $community, 'indexModuleSelection' => $indexModuleSelection]);
    }

    /**
     * Archives the community
     */
    public function actionArchive()
    {
        $community = $this->getCommunity();
        $community->archive();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return [
                'success' => true,
                'community' => Chooser::getCommunityResult($community, true, ['isMember' => true])
            ];
        }

        return $this->redirect($community->createUrl('/community/manage'));
    }

    /**
     * Unarchives the community
     */
    public function actionUnarchive()
    {
        $community = $this->getCommunity();
        $community->unarchive();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return [
                'success' => true,
                'community' => Chooser::getCommunityResult($community, true, ['isMember' => true])
            ];
        }

        return $this->redirect($community->createUrl('/community/manage'));
    }

    /**
     * Deletes this Community
     */
    public function actionDelete()
    {
        $model = new DeleteForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->getCommunity()->delete();
            return $this->goHome();
        }

        return $this->render('delete', ['model' => $model, 'community' => $this->getCommunity()]);
    }

}

?>
