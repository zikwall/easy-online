<?php

namespace zikwall\easyonline\modules\core\components\managers;

use Yii;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\core\libs\BaseSettingsManager;
use zikwall\easyonline\modules\content\components\ContentContainerActiveRecord;
use zikwall\easyonline\modules\content\components\ContentContainerSettingsManager;
use zikwall\easyonline\modules\user\models\User;

class SettingsManager extends BaseSettingsManager
{
    /**
     * @var ContentContainerSettingsManager[] уже загруженные настройки контейнеров содержимого
     */
    protected $contentContainers = [];

    /**
     * Возвращает контейнер содержимого
     *
     * @param ContentContainerActiveRecord $container
     * @return ContentContainerSettingsManager
     */
    public function contentContainer(ContentContainerActiveRecord $container) : ContentContainerSettingsManager
    {
        if (isset($this->contentContainers[$container->contentcontainer_id])) {
            return $this->contentContainers[$container->contentcontainer_id];
        }
        $this->contentContainers[$container->contentcontainer_id] = new ContentContainerSettingsManager([
            'moduleId' => $this->moduleId,
            'contentContainer' => $container,
        ]);

        return $this->contentContainers[$container->contentcontainer_id];
    }

    /**
     * Возвращает ContentContainerSettingsManager для данного пользователя или текущего зарегистрированного пользователя
     *
     * @param User|null $user
     * @return ContentContainerSettingsManager
     * @throws \Throwable
     */
    public function user(User $user = null) : ContentContainerSettingsManager
    {
        if (!$user) {
            $user = Yii::$app->user->getIdentity();
        }
        return $this->contentContainer($user);
    }

    /**
     * Returns ContentContainerSettingsManager for the given $cummnity or current controller community
     * @return ContentContainerSettingsManager
     */
    public function community($community = null)
    {
        if ($community != null) {
            return $this->contentContainer($community);
        } elseif (Yii::$app->controller instanceof ContentContainerController) {
            if (Yii::$app->controller->contentContainer instanceof Community) {
                return $this->contentContainer(Yii::$app->controller->contentContainer);
            }
        }
    }

    /**
     * Указывает, что этот параметр зафиксирован в файле конфигурации и не может быть изменен во время работы приложения.
     *
     * @param string $name
     * @return bool
     */
    public function isFixed(string $name) : bool
    {
        return isset(Yii::$app->params['fixed-settings'][$this->moduleId][$name]);
    }

    /**
     * @inheritdoc
     */
    public function get($name, $default = null)
    {
        if ($this->isFixed($name)) {
            return Yii::$app->params['fixed-settings'][$this->moduleId][$name];
        }

        return parent::get($name, $default);
    }
}
