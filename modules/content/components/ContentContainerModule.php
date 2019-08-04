<?php

namespace zikwall\easyonline\modules\content\components;

use zikwall\easyonline\modules\core\components\Module;

/**
 * Базовый модуль с поддержкой ContentContainer - оболочек контента.
 *
 * Переопределите этот класс, если ваш модуль должен иметь возможность быть
 * включено/отключено в контейнере содержимого (например, Пользователь).
 *
 */
class ContentContainerModule extends Module
{
    /**
     * Возвращает список допустимых классов контейнеров содержимого, поддерживаемых этим модулем.
     * 
     * ```php
     * public function getContentContainerTypes()
     * {
     *      return [
     *          User::class,
     *      ];
     * }
     * ```
     * 
     * @return array valid content container classes
     */
    public function getContentContainerTypes()
    {
        return [];
    }

    /**
     * Проверяет, включен ли модуль для данной оболочки контента
     * 
     * @param string $class the class of content container
     * @return boolean
     */
    public function hasContentContainerType($class)
    {
        return in_array($class, $this->getContentContainerTypes());
    }

    /**
     * Возвращает описание модуля, указанное в разделе модулей контейнера содержимого.
     * По умолчанию возвращается описание основного модуля.
     * 
     * @param string $container
     * @return string the module description
     */
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        return $this->getDescription();
    }

    /**
     * Возвращает имя модуля, используемого в контексте контейнера содержимого.
     * По умолчанию возвращается имя основного модуля.
     * 
     * @param ContentContainerActiveRecord $container
     * @return string the module name
     */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return $this->getName();
    }

    /**
     * Возвращает URL-адрес изображения модуля, показанного в разделе модуля содержимого контейнера.
     * По умолчанию возвращается URL-адрес основного модуля.
     * 
     * @param ContentContainerActiveRecord $container
     * @return string the url to the image
     */
    public function getContentContainerImage(ContentContainerActiveRecord $container)
    {
        return $this->getImage();
    }

    /**
     * Возвращает URL-адрес для настройки этого модуля в контейнере содержимого
     * 
     * @param ContentContainerActiveRecord $container
     * @return string the config url
     */
    public function getContentContainerConfigUrl(ContentContainerActiveRecord $container)
    {
        return "";
    }

    /**
     * Включает этот модуль в данном контейнере содержимого
     * Переопределите этот метод, например. для установки настроек по умолчанию.
     * 
     * @param ContentContainerActiveRecord $container
     */
    public function enableContentContainer(ContentContainerActiveRecord $container)
    {
        
    }

    /**
     * Отключает модуль в контейнере содержимого
     * Переопределите этот метод для очистки созданных данных в контексте контейнера содержимого.
     * 
     * ```php
     * public function disableContentContainer(ContentContainerActiveRecord $container)
     * {
     *      parent::disableContentContainer($container);
     *      foreach (MyContent::find()->contentContainer($container)->all() as $content) {
     *          $content->delete();
     *      }
     * }
     * ```
     * 
     * @param ContentContainerActiveRecord $container the content container
     */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        $this->settings->contentContainer($container)->deleteAll();
    }

    /**
     * Возвращает массив всех контейнеров содержимого, в которых этот модуль включен.
     * 
     * @param string $containerClass
     * @return array of content container instances
     */
    public function getEnabledContentContainers($containerClass = "")
    {
        return [];
    }

}
