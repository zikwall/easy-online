<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190805_074749_init_content_permissions
 */
class m190805_074749_init_content_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('contentcontainer_permission', array(
            'permission_id' =>  $this->string(150)->notNull(),
            'contentcontainer_id' => Schema::TYPE_INTEGER,
            'group_id' =>  $this->string(50)->notNull(),
            'module_id' => $this->string(50)->notNull(),
            'class' => Schema::TYPE_STRING,
            'state' => Schema::TYPE_BOOLEAN,
        ));
        $this->addPrimaryKey('contentcontainer_permission_pk', 'contentcontainer_permission', ['permission_id', 'group_id', 'module_id', 'contentcontainer_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_074749_init_content_permissions cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_074749_init_content_permissions cannot be reverted.\n";

        return false;
    }
    */
}
