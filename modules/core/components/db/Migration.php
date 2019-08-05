<?php

namespace zikwall\easyonline\modules\core\components\db;

use Yii;


class Migration extends \yii\db\Migration
{
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
