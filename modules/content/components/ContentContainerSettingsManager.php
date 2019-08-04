<?php

namespace zikwall\easyonline\modules\content\components;

use Yii;
use zikwall\easyonline\modules\core\libs\BaseSettingsManager;

class ContentContainerSettingsManager extends BaseSettingsManager
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'zikwall\easyonline\modules\content\models\ContentContainerSetting';

    /**
     * @var ContentContainerActiveRecord the content container this settings manager belongs to
     */
    public $contentContainer;
    
    /**
     * Возвращает значение настройки этого контейнера для заданного параметра $name.
     * Если не существует конкретных параметров контейнера, эта функция будет искать глобальные настройки или
     * вернуть значение по умолчанию или null, если глобальная настройка также отсутствует.
     */
    public function getInherit(string $name, string  $default = null) : bool
    {
        $result = $this->get($name);
        return ($result !== null)
            ? $result
            : Yii::$app->getModule($this->moduleId)->settings->get($name, $default);
    }

    public function getSerializedInherit(string $name, string $default = null)  : bool
    {
        $result = $this->getSerialized($name);
        return ($result !== null) ? $result
            : Yii::$app->getModule($this->moduleId)->settings->getSerialized($name, $default);
    }

    /**
     * @inheritdoc
     */
    protected function createRecord()
    {
        $record = parent::createRecord();
        $record->contentcontainer_id = $this->contentContainer->contentContainerRecord->id;
        return $record;
    }

    /**
     * @inheritdoc
     */
    protected function find()
    {
        return parent::find()->andWhere(['contentcontainer_id' => $this->contentContainer->contentContainerRecord->id]);
    }

    /**
     * @inheritdoc
     */
    protected function getCacheKey()
    {
        return parent::getCacheKey() . '-' . $this->contentContainer->id;
    }
}
