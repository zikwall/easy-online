<?php

use yii\db\Migration;

/**
 * Class m190805_075245_init_optimize_user
 */
class m190805_073145_init_optimize_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createIndex('unique_email', 'user', 'email', true);
        $this->createIndex('unique_username', 'user', 'username', true);
        $this->createIndex('unique_guid', 'user', 'guid', true);
        $this->createIndex('index_profile_field_category', 'profile_field', 'profile_field_category_id', false);
        $this->createIndex('index_user_module', 'user_module', 'user_id, module_id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_075245_init_optimize_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_075245_init_optimize_user cannot be reverted.\n";

        return false;
    }
    */
}
