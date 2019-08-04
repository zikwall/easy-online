<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\admin\components\Controller;
use zikwall\easyonline\modules\user\models\forms\Registration;
use zikwall\easyonline\modules\user\models\User;
use yii\web\NotFoundHttpException;
use zikwall\easyonline\modules\admin\permissions\ManageSettings;
use zikwall\easyonline\modules\user\models\UserSearch;
use zikwall\easyonline\modules\user\permissions\ManageGroups;
use zikwall\easyonline\modules\user\permissions\ManageUsers;
use zikwall\easyonline\modules\core\components\compatibility\HForm;
use zikwall\easyonline\modules\user\models\forms\UserEditForm;

class AdminController extends Controller
{
    private $_model = false;

    public function init()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Users'));
        $this->subLayout = '@zikwall/easyonline/modules/user/views/layouts/admin';
    }

    /**
     * @inheritdoc
     */
    public function getAccessRules()
    {
        return [
            ['permissions' => [
                ManageUsers::class,
                ManageGroups::class
            ]
            ],
            [
                'permissions' => ManageSettings::class,
                'actions' => ['index']
            ]
        ];
    }


    public function actionIndex()
    {
        if (Yii::$app->user->can([new ManageUsers(), new ManageGroups()])) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel
            ]);
        } else if (Yii::$app->user->can(new ManageSettings())) {
            $this->redirect(['/user/authentication']);
        } else {
            $this->forbidden();
        }
    }

    public function actionEdit()
    {
        $user = UserEditForm::findOne([
            'id' => Yii::$app->request->get('id')
        ]);
        $user->initGroupSelection();

        if ($user == null) {
            throw new \yii\web\HttpException(404, Yii::t('AdminModule.controllers_UserController', 'User not found!'));
        }

        $user->scenario = 'editAdmin';
        $user->profile->scenario = 'editAdmin';
        $profile = $user->profile;

        // Определение формы
        $definition = [];
        $definition['elements'] = [];
        // Добавить форму пользователя
        $definition['elements']['User'] = [
            'type' => 'form',
            'title' => 'Account',
            'elements' => [
                'username' => [
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 25,
                ],
                'email' => [
                    'type' => 'text',
                    'class' => 'form-control',
                    'maxlength' => 100,
                ],
                'groupSelection' => [
                    'id' => 'user_edit_groups',
                    'type' => 'multiselectdropdown',
                    'items' => UserEditForm::getGroupItems(),
                    'options' => [
                        'data-placeholder' => Yii::t('AdminModule.controllers_UserController', 'Select Groups'),
                        'data-placeholder-more' => Yii::t('AdminModule.controllers_UserController', 'Add Groups...'),
                    ],
                    'isVisible' => Yii::$app->user->can(new ManageGroups())
                ],
                'status' => [
                    'type' => 'dropdownlist',
                    'class' => 'form-control',
                    'items' => [
                        User::STATUS_ENABLED => Yii::t('AdminModule.controllers_UserController', 'Enabled'),
                        User::STATUS_DISABLED => Yii::t('AdminModule.controllers_UserController', 'Disabled'),
                        User::STATUS_NEED_APPROVAL => Yii::t('AdminModule.controllers_UserController', 'Unapproved'),
                    ],
                ]
            ],
        ];

        // Добавить форму профиля
        $definition['elements']['Profile'] = array_merge(['type' => 'form'], $profile->getFormDefinition());

        // Определение формы
        $definition['buttons'] = [
            'save' => [
                'type' => 'submit',
                'label' => Yii::t('AdminModule.controllers_UserController', 'Save'),
                'class' => 'flat_button button_wide',
            ],
            'become' => [
                'type' => 'submit',
                'label' => Yii::t('AdminModule.controllers_UserController', 'Become this user'),
                'class' => 'flat_button button_wide danger',
                'isVisible' => $this->canBecomeUser($user)
            ],
            'delete' => [
                'type' => 'submit',
                'label' => Yii::t('AdminModule.controllers_UserController', 'Delete'),
                'class' => 'flat_button button_wide danger',
            ],
        ];

        $form = new HForm($definition);
        $form->contentWrapperClass = 'page_info_wrap';
        $form->footerWrapperClass = 'block_footer';
        $form->models['User'] = $user;
        $form->models['Profile'] = $profile;

        if ($form->submitted('save') && $form->validate()) {
            if ($form->save()) {
                $this->view->saved();
                return $this->redirect(['/user/admin']);
            }
        }

        if ($form->submitted('become') && $this->canBecomeUser($user)) {
            Yii::$app->user->switchIdentity($form->models['User']);
            return $this->redirect(Url::home());
        }

        if ($form->submitted('delete')) {
            return $this->redirect(['/user/admin/delete', 'id' => $user->id]);
        }

        return $this->render('edit', [
            'hForm' => $form,
            'user' => $user
        ]);
    }

    public function actionAdd()
    {
        $registration = new Registration();
        $registration->enableEmailField = true;
        $registration->enableUserApproval = false;
        if ($registration->submitted('save') && $registration->validate() && $registration->register()) {
            return $this->redirect(['edit', 'id' => $registration->getUser()->id]);
        }
        $registration->contentWrapperClass = 'page_info_wrap';
        $registration->footerWrapperClass = 'block_footer';

        return $this->render('add', ['hForm' => $registration]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPermissions($id)
    {
        $modelForm = new AssignmentForm;
        $modelForm->model = $this->findModel($id);

        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->save()) {
            Yii::$app->session->setFlash('success', Yii::t('users', 'SUCCESS_UPDATE_PERMISSIONS'));
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('permissions', [
            'modelForm' => $modelForm
        ]);
    }

    protected function findModel($id)
    {
        if ($this->_model === false) {
            $this->_model = User::findOne($id);
        }

        if ($this->_model !== null) {
            return $this->_model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function canBecomeUser($user)
    {
        return Yii::$app->user->isAdmin() && $user->id != Yii::$app->user->getIdentity()->id && !$user->isSystemAdmin();
    }
}
