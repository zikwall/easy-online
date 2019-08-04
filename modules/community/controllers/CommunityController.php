<?php

namespace zikwall\easyonline\modules\community\controllers;

use Yii;
use yii\web\HttpException;
use yii\db\Expression;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\core\behaviors\AccessControl;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\widgets\UserListBox;
use zikwall\easyonline\modules\community\widgets\Menu;
use zikwall\easyonline\modules\post\permissions\CreatePost;

class CommunityController extends ContentContainerController
{
    /**
     * @inheritdoc
     */
    public $hideSidebar = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'guestAllowedActions' => ['index', 'stream'],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    /*public function actions()
    {
        return [
            'stream' => [
                'class' => ContentContainerStream::class,
                'contentContainer' => $this->contentContainer
            ],
        ];
    }*/

    /**
     * Generic Start Action for Profile
     */
    public function actionIndex()
    {
        $community = $this->getCommunity();

        if (Yii::$app->request->get('tour') || Yii::$app->request->get('contentId')) {
            return $this->actionHome();
        }

        if (!$community->isMember()) {
            $defaultPageUrl = Menu::getGuestsDefaultPageUrl($community);
            if ($defaultPageUrl != null) {
                return $this->redirect($defaultPageUrl);
            }
        }

        $defaultPageUrl = Menu::getDefaultPageUrl($community);
        if ($defaultPageUrl != null) {
            return $this->redirect($defaultPageUrl);
        }

        return $this->actionHome();
    }

    /**
     * Default community homepage
     *
     * @return type
     */
    public function actionHome()
    {
        $community = $this->contentContainer;
        $canCreatePosts = true; //$community->permissionManager->can(new CreatePost());
        $isMember = $community->isMember();

        return $this->render('home', [
            'community' => $community,
            'canCreatePosts' => $canCreatePosts,
            'isMember' => $isMember
        ]);
    }

    public function actionFollow()
    {
        if (Yii::$app->getModule('community')->disableFollow) {
            throw new HttpException(403, Yii::t('ContentModule.controllers_ContentController', 'This action is disabled!'));
        }

        $this->forcePostRequest();
        $community = $this->getCommunity();

        $success = false;

        if (!$community->isMember()) {
            $success = $community->follow(null, false);
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => $success];
        }

        return $this->redirect($community->getUrl());
    }

    public function actionUnfollow()
    {
        $this->forcePostRequest();
        $community = $this->getCommunity();

        $success = $community->unfollow();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            return ['success' => $success];
        }

        return $this->redirect($community->getUrl());
    }

    /**
     * Modal to  list followers of a community
     */
    public function actionFollowerList()
    {
        $query = User::find();
        $query->leftJoin('user_follow', 'user.id=user_follow.user_id AND object_model=:userClass AND user_follow.object_id=:communityId', [':userClass' => Community::class, ':communityId' => $this->getCommunity()->id]);
        $query->orderBy(['user_follow.id' => SORT_DESC]);
        $query->andWhere(['IS NOT', 'user_follow.id', new Expression('NULL')]);
        $query->visible();

        $title = Yii::t('CommunityModule.base', '<strong>Community</strong> followers');

        return $this->renderAjaxContent(UserListBox::widget(['query' => $query, 'title' => $title]));
    }

}
