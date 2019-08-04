<?php

namespace zikwall\easyonline\modules\core\components\db;

use Yii;


class Migration extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public $tablePrefix = '';

    /**
     * @inheritdoc
     */
    public $tableNameSeparator = '';

    public function createTable($table, $columns, $options = null)
    {
        if ($options === null && $this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        parent::createTable($table, $columns, $options);
    }

    /**
     * Real table name builder
     *
     * ```php
     * $this->createTable($this->tn('table1'), [
     *      'id' => $this->primaryKey(),
     *      'name' => $this->string()->notNull(),
     * ]);
     * ```
     *
     * @param string $name table name
     * @return string
     */
    protected function tn($name)
    {
        return '{{%' . $this->tablePrefix . $this->tableNameSeparator . $name . '}}';
    }

    /**
     * Foreign key relation names generator
     *
     * ```php
     * $this->addForeignKey(
     *      $this->fk('table1', 'table2'),
     *      $this->tn('table1'), 'ref_id',
     *      $this->tn('table2'), 'id',
     *      'CASCADE', 'CASCADE'
     * );
     * ```
     *
     * @param string $table1 first table in relation
     * @param string $table2 second table in relation
     * @return string
     */
    protected function fk($table1, $table2)
    {
        return 'fk_' . $this->tablePrefix .  $this->tableNameSeparator  . $table1 . '_' . $table2;
    }

    /**
     * Создает и выполняет инструкцию UPDATE SQL без вывода.
     * Метод будет удалять имена столбцов и связывать значения, подлежащие обновлению.
     *
     * @param string $table
     * @param array $columns
     *      Format: name => value
     * @param array|string $condition условия, которые будут помещены в часть WHERE.
     *      Format: [[Query::where()]]
     * @param array $params the parameters to be bound to the query.
     */
    public function updateSilent(string $table, array $columns, $condition = '', array $params = [])
    {
        $this->db->createCommand()->update($table, $columns, $condition, $params)->execute();
    }

    /**
     * Создает и выполняет инструкцию INSERT SQL без вывода
     * Метод будет удалять имена столбцов и привязывать значения, которые нужно вставить.
     * @param string $table
     * @param array $columns
     *      Format: name => value
     */
    public function insertSilent(string $table, array $columns)
    {
        $this->db->createCommand()->insert($table, $columns)->execute();
    }

}
