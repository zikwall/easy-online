<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use zikwall\easyonline\modules\admin\components\Controller;
use zikwall\easyonline\modules\user\models\Group;
use zikwall\easyonline\modules\user\models\GroupUser;
use zikwall\easyonline\modules\user\models\forms\EditGroupForm;
use zikwall\easyonline\modules\user\models\UserPicker;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\admin\models\forms\AddGroupMemberForm;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\models\GroupSearch;
use zikwall\easyonline\modules\user\models\UserSearch;

class GroupController extends Controller
{

    /**
     * @inheritdoc
     */
    public $adminOnly = false;

    public function init()
    {
        $this->subLayout = '@user/views/layouts/admin';
        $this->view->title = $this->appendPageTitle(Yii::t('AdminModule.base', 'Groups'));
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => ManageGroups::class]
        ];
    }

    /**
     * List all available user groups
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionEdit()
    {
        $group = EditGroupForm::findOne(['id' => Yii::$app->request->get('id')]);

        if (!$group) {
            $group = new EditGroupForm();
        }

        $wasNew = $group->isNewRecord;

        if ($group->load(Yii::$app->request->post()) && $group->validate() && $group->save()) {
            $this->view->saved();
            if ($wasNew) {
                return $this->redirect([
                    '/user/group/manage-group-users',
                    'id' => $group->id
                ]);
            }
        }

        return $this->render('edit', [
            'group' => $group,
            'showDeleteButton' => (!$group->isNewRecord && !$group->is_admin_group),
            'isCreateForm' => $group->isNewRecord,
            'isManagerApprovalSetting' => Yii::$app->getModule('user')->settings->get('auth.needApproval')
        ]);
    }

    public function actionManagePermissions()
    {
        $group = Group::findOne(['id' => Yii::$app->request->get('id')]);

        if (!$group->isNewRecord && Yii::$app->request->post('dropDownColumnSubmit')) {
            Yii::$app->response->format = 'json';
            $permission = Yii::$app->user->permissionManager->getById(Yii::$app->request->post('permissionId'), Yii::$app->request->post('moduleId'));
            if ($permission === null) {
                throw new \yii\web\HttpException(500, 'Could not find permission!');
            }
            Yii::$app->user->permissionManager->setGroupState($group->id, $permission, Yii::$app->request->post('state'));
            return [];
        }

        return $this->render('permissions', ['group' => $group]);
    }

    public function actionManageGroupUsers()
    {
        $group = Group::findOne(['id' => Yii::$app->request->get('id')]);

        if (!$group){
            throw new NotFoundHttpException('Group not found!');
        }

        $searchModel = new UserSearch();
        $searchModel->query = $group->getUsers();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('members', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'group' => $group,
            'addGroupMemberForm' => new AddGroupMemberForm(),
            'isManagerApprovalSetting' => Yii::$app->getModule('user')->settings->get('auth.needApproval')
        ]);
    }

    public function actionRemoveGroupUser()
    {
        $this->forcePostRequest();
        $group = Group::findOne(['id' => Yii::$app->request->get('id')]);
        $group->removeUser(Yii::$app->request->get('userId'));

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }

        return $this->redirect([
            '/user/group/manage-group-users',
            'id' => $group->id
        ]);
    }

    public function actionEditManagerRole()
    {
        Yii::$app->response->format = 'json';
        $this->forcePostRequest();
        $group = Group::findOne(Yii::$app->request->post('id'));
        $value = Yii::$app->request->post('value');

        if ($group == null) {
            throw new \yii\web\HttpException(404, Yii::t('AdminModule.controllers_GroupController', 'Group not found!'));
        } else if ($value == null) {
            throw new \yii\web\HttpException(400, Yii::t('AdminModule.controllers_GroupController', 'No value found!'));
        }

        $groupUser = $group->getGroupUser(User::findOne(Yii::$app->request->post('userId')));

        if ($groupUser == null) {
            throw new \yii\web\HttpException(404, Yii::t('AdminModule.controllers_GroupController', 'Group user not found!'));
        }


        $groupUser->is_group_manager = ($value) ? true : false;
        $groupUser->save();

        return ['success' => true];
    }

    public function actionAddMembers()
    {
        $this->forcePostRequest();
        $form = new AddGroupMemberForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->save();
        }

        return $this->redirect([
            '/user/group/manage-group-users',
            'id' => $form->groupId
        ]);
    }

    public function actionNewMemberSearch()
    {
        Yii::$app->response->format = 'json';

        $keyword = Yii::$app->request->get('keyword');
        $group = Group::findOne(Yii::$app->request->get('id'));

        $subQuery = (new \yii\db\Query())->select('*')->from(GroupUser::tableName(). ' g')->where([
                    'and', 'g.user_id=user.id', ['g.group_id' => $group->id]]);

        $query = User::find()->where(['not exists', $subQuery]);

        $result = UserPicker::filter([
            'keyword' => $keyword,
            'query' => $query,
            'fillUser' => true,
            'fillUserQuery' => $group->getUsers(),
            'disabledText' => Yii::t('AdminModule.controllers_GroupController', 'User is already a member of this group.')
        ]);

        return $result;
    }

    public function actionAdminUserSearch()
    {
        Yii::$app->response->format = 'json';

        $keyword = Yii::$app->request->get('keyword');
        $group = Group::findOne(Yii::$app->request->get('id'));

        return UserPicker::filter([
            'query' => $group->getUsers(),
            'keyword' => $keyword,
            'fillQuery' => User::find(),
            'disableFillUser' => false
        ]);
    }

}
