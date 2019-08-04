<?php

namespace zikwall\easyonline\modules\core\behaviors;

use Yii;
use yii\base\Behavior;

class PolymorphicRelation extends Behavior
{

    /**
     * @var string атрибут имени класса
     */
    public $classAttribute = 'object_model';

    /**
     * @var string атрибут первичного ключа
     */
    public $pkAttribute = 'object_id';

    /**
     * @var array связанный объект должен быть «экземпляром» по крайней мере одного из этих заданных классов
     */
    public $mustBeInstanceOf = array();

    /**
     * @var mixed кешированный объект
     */
    private $_cached = null;

    /**
     * Возвращает базовый объект
     *
     * @return mixed
     */
    public function getPolymorphicRelation()
    {

        if ($this->_cached !== null) {
            return $this->_cached;
        }

        $className = $this->owner->getAttribute($this->classAttribute);

        if ($className == "") {
            return null;
        }

        if (!class_exists($className)) {
            Yii::error("Underlying object class " . $className . " not found!");
            return null;
        }

        $tableName = $className::tableName();
        $object = $className::find()->where([$tableName . '.id' => $this->owner->getAttribute($this->pkAttribute)])->one();

        if ($object !== null && $this->validateUnderlyingObjectType($object)) {
            $this->_cached = $object;
            return $object;
        }

        return null;
    }

    /**
     * Устанавливает связанный объект
     *
     * @param mixed $object
     */
    public function setPolymorphicRelation($object)
    {
        if ($this->validateUnderlyingObjectType($object)) {
            $this->_cached = $object;

            if ($object instanceof \yii\db\ActiveRecord) {
                $this->owner->setAttribute($this->classAttribute, $object->className());
                $this->owner->setAttribute($this->pkAttribute, $object->getPrimaryKey());
            }
        }
    }

    /**
     * Сбрасывает уже загруженный экземпляр $_cached связанного объекта
     */
    public function resetPolymorphicRelation()
    {
        $this->_cached = null;
    }

    /**
     * Проверяет, разрешен ли заданный объект
     */
    private function validateUnderlyingObjectType($object) : bool
    {
        if (count($this->mustBeInstanceOf) == 0) {
            return true;
        }

        foreach ($this->mustBeInstanceOf as $instance) {
            if ($object instanceof $instance) {
                return true;
            }
        }

        Yii::error('Got invalid underlying object type! (' . $object->className() . ')');
        
        return false;
    }

}
