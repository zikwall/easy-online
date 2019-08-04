<?php



namespace zikwall\easyonline\modules\community\modules\manage\controllers;

use Yii;
use zikwall\easyonline\modules\community\modules\manage\components\Controller;
use zikwall\easyonline\modules\community\models\Community;
use yii\web\HttpException;

/**
 * SecurityController
 * 
 * @since 1.1
 * @author Luke
 */
class SecurityController extends Controller
{

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

    /**
     * Shows community permessions
     */
    public function actionPermissions()
    {
        $community = $this->getCommunity();

        $groups = $community->getUserGroups();
        $groupId = Yii::$app->request->get('groupId', Community::USERGROUP_MEMBER);
        if (!array_key_exists($groupId, $groups)) {
            throw new HttpException(500, 'Invalid group id given!');
        }

        // Handle permission state change
        if (Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $permission = $community->permissionManager->getById(Yii::$app->request->post('permissionId'), Yii::$app->request->post('moduleId'));
            if ($permission === null) {
                throw new HttpException(500, 'Could not find permission!');
            }
            $community->permissionManager->setGroupState($groupId, $permission, Yii::$app->request->post('state'));
            return [];
        }

        return $this->render('permissions', [
                    'community' => $community,
                    'groups' => $groups,
                    'groupId' => $groupId
        ]);
    }

}
