<?php

use yii\db\Migration;

/**
 * Class m190805_081504_init_invite
 */
class m190805_081504_init_invite extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%user_invite}}', [
            'id' => 'pk',
            'user_originator_id' => 'int(11) DEFAULT NULL',
            'space_invite_id' => 'int(11) DEFAULT NULL',
            'email' => 'varchar(45) NOT NULL',
            'source' => 'varchar(45) DEFAULT NULL',
            'token' => 'varchar(45) DEFAULT NULL',
            'created_at' => 'datetime DEFAULT NULL',
            'created_by' => 'int(11) DEFAULT NULL',
            'updated_at' => 'datetime DEFAULT NULL',
            'updated_by' => 'int(11) DEFAULT NULL',
        ], '');

        $this->addColumn('{{%user_invite}}', 'firstname', 'varchar(255)');
        $this->addColumn('{{%user_invite}}', 'lastname', 'varchar(255)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_081504_init_invite cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_081504_init_invite cannot be reverted.\n";

        return false;
    }
    */
}
