<?php

namespace zikwall\easyonline\modules\content\components;

use Yii;
use yii\web\HttpException;
use zikwall\easyonline\modules\user\behaviors\ProfileController;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\core\components\base\Controller;
use zikwall\easyonline\modules\community\behaviors\CommunityController;
use zikwall\easyonline\modules\community\models\Community;

/**
 * ContainerController - это базовый контроллер для всех контроллеров пользовательского профиля.
 * Он автоматически определяет Контейнер по параметрам запроса.
 * Используйте метод [[ContentContainerActiveCreated::createUrl]] для создания URL-адресов.
 * например. $this->contentContainer->createUrl();
 * Зависит от загруженного типа контейнера. Поведение с дополнительными методами будет подключено.
 * - User attached Behavior: \zikwall\easyonline\modules\user\behaviors\ProfileController
 * - .. your custom Containers, example - Communities
 */
class ContentContainerController extends Controller
{
    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer = null;

    /**
     * @var boolean automatic check user access permissions to this container
     */
    public $autoCheckContainerAccess = true;

    /**
     * @var boolean ToDo: скрывает боковую панель контейнеров в макете пользователей
     */
    public $hideSidebar = true;

    /**
     * Автоматически загружает базовый контент Контейнер (Пользователь), используя
     * параметр запроса uguid
     *
     * @return bool
     * @throws HttpException
     */
    public function init()
    {
        $request = Yii::$app->request;
        $userGuid = $request->get('uguid');
        $communityGuid = $request->get('sguid');

        if ($communityGuid !== null) {

            $this->contentContainer = Community::findOne(['guid' => $communityGuid]);
            if ($this->contentContainer == null) {
                throw new HttpException(404, Yii::t('base', 'Space not found!'));
            }

            $this->attachBehavior('CommunityControllerBehavior', [
                'class' => CommunityController::class,
                'community' => $this->contentContainer,
            ]);
            $this->subLayout = CommunityController::$subLayout;

            // Handle case, if a non-logged user tries to acccess a hidden space
            // Redirect to Login instead of showing error
            if ($this->contentContainer->visibility == Community::VISIBILITY_NONE && Yii::$app->user->isGuest) {

            }

        } elseif ($userGuid !== null) {

            $this->contentContainer = User::findOne(['guid' => $userGuid]);
            if ($this->contentContainer == null) {
                throw new HttpException(404, Yii::t('base', 'User not found!'));
            }

            $this->attachBehavior('ProfileControllerBehavior', [
                'class' => ProfileController::class,
                'user' => $this->contentContainer,
            ]);

            $this->subLayout = ProfileController::$subLayout;

        } else {
            throw new HttpException(500, Yii::t('base', 'Could not determine content container!'));
        }

        /**
         * ToDo: create custom containers e.g Communities
         */

        /**
         * Автоматическая проверка прав доступа к этому контейнеру
         */
        if ($this->contentContainer != null && $this->autoCheckContainerAccess) {
            $this->checkContainerAccess();
        }

        if (!$this->checkModuleIsEnabled()) {
            throw new HttpException(405, Yii::t('base', 'Module is not enabled on this content container!'));
        }

        return parent::init();
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action) === false) {
            return false;
        }

        // Непосредственно перенаправлять гостей на страницу входа - если гостевой доступ не включен
        if (Yii::$app->user->isGuest && Yii::$app->getModule('user')->settings->get('auth.allowGuestAccess') != 1) {
            Yii::$app->user->loginRequired();
            return false;
        }

        return true;
    }

    /**
     * Проверяет, может ли текущий пользователь получить доступ к текущему ContentContainer, используя
     * базовое поведение ProfileControllerBehavior.
     * Если проверка доступа не удалась, выбрано HttpException.
     */
    public function checkContainerAccess()
    {
        // Данный метод ыполненяется поведением оболочки контента
        $this->checkAccess();
    }

    /**
     * Проверяет, включен ли текущий модуль в этом контейнере содержимого.
     *
     * @todo Also support submodules
     */
    public function checkModuleIsEnabled() : bool
    {
        if ($this->module instanceof ContentContainerModule && $this->contentContainer !== null) {
            return $this->contentContainer->isModuleEnabled($this->module->id);
        }

        return true;
    }

}
