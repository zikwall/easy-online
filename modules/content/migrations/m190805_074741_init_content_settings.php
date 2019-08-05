<?php

use zikwall\easyonline\modules\core\commands\MigrateController;
use yii\db\Schema;
use yii\db\Query;

/**
 * Class m190805_074741_init_content_settings
 */
class m190805_074741_init_content_settings extends \yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('contentcontainer_setting', [
            'id' => Schema::TYPE_PK,
            'module_id' => $this->string(50)->notNull(),
            'contentcontainer_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => $this->string(50)->notNull(),
            'value' => Schema::TYPE_TEXT . ' NOT NULL',
        ]);

        $this->createIndex('settings-unique', 'contentcontainer_setting', ['module_id', 'contentcontainer_id', 'name'], true);
        $this->addForeignKey('fk-contentcontainerx', 'contentcontainer_setting', 'contentcontainer_id', 'contentcontainer', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_074741_init_content_settings cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_074741_init_content_settings cannot be reverted.\n";

        return false;
    }
    */
}
