<?php

namespace zikwall\easyonline\modules\user\controllers;

use Yii;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\community\models\Membership;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\core\behaviors\AccessControl;
use zikwall\easyonline\modules\feed\actions\ContentContainerFeed;
use zikwall\easyonline\modules\community\widgets\ListBox;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\permissions\ViewAboutPage;
use zikwall\easyonline\modules\user\widgets\UserListBox;
use zikwall\easyonline\modules\user\exceptions\ProfileForbidden;

class ProfileController extends ContentContainerController
{
    public $hideSidebar = false;
    public $enableCsrfValidation = false;

    //public $layout = '@user/views/layouts/profile';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['index', 'about']
            ]
        ];
    }

    public function actionIndex()
    {
        if ($this->module->profileDefaultRoute !== null) {
            return $this->redirect($this->getUser()->createUrl($this->module->profileDefaultRoute));
        }

        return $this->actionHome();
    }

    public function actionHome()
    {
        return $this->render('home', ['user' => $this->contentContainer]);
    }

    /**
     * @return string
     * @throws ProfileForbidden
     */
    public function actionAbout()
    {
        if (!$this->contentContainer->permissionManager->can(new ViewAboutPage())) {
            throw new ProfileForbidden('Forbidden', $this->getUser());
        }

        return $this->render('about', ['user' => $this->contentContainer]);
    }

    public function actionFollow()
    {
        if (Yii::$app->getModule('user')->disableFollow) {
            throw new \yii\web\HttpException(403, Yii::t('ContentModule.controllers_ContentController', 'This action is disabled!'));
        }
        
        //$this->forcePostRequest();
        $this->getUser()->follow(Yii::$app->user->getIdentity(), false);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }

        return $this->redirect($this->getUser()->getUrl());
    }

    public function actionUnfollow()
    {
        //$this->forcePostRequest();
        $this->getUser()->unfollow();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => true];
        }

        return $this->redirect($this->getUser()->getUrl());
    }

    public function actionFollowerList()
    {
        $query = User::find();
        $query->leftJoin('user_follow', 'user.id=user_follow.user_id and object_model=:userClass and user_follow.object_id=:userId', [':userClass' => User::class, ':userId' => $this->getUser()->id]);
        $query->orderBy(['user_follow.id' => SORT_DESC]);
        $query->andWhere(['IS NOT', 'user_follow.id', new \yii\db\Expression('NULL')]);
        $query->active();

        $title = Yii::t('UserModule.widgets_views_userFollower', '<strong>User</strong> followers');
        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

    public function actionFollowedUsersList()
    {
        $query = User::find();
        $query->leftJoin('user_follow', 'user.id=user_follow.object_id and object_model=:userClass and user_follow.user_id=:userId', [':userClass' => User::class, ':userId' => $this->getUser()->id]);
        $query->orderBy(['user_follow.id' => SORT_DESC]);
        $query->andWhere(['IS NOT', 'user_follow.id', new \yii\db\Expression('NULL')]);
        $query->active();

        $title = Yii::t('UserModule.widgets_views_userFollower', '<strong>Following</strong> user');
        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }
}

?>
