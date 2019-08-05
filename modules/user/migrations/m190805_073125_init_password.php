<?php

use yii\db\Migration;

class m190805_073125_init_password extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_password}}', [
            'id' => 'pk',
            'user_id' => 'int(10) DEFAULT NULL',
            'algorithm' => 'varchar(20) DEFAULT NULL',
            'password' => 'text DEFAULT NULL',
            'salt' => 'text DEFAULT NULL',
            'created_at' => 'datetime DEFAULT NULL',
                ], '');

        $this->createIndex('idx_user_id', '{{%user_password}}', 'user_id', false);
    }

    public function down()
    {
        echo "m140303_125031_password does not support migration down.\n";
        return false;
    }
}
