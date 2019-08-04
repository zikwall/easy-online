<?php

use app\modules\core\components\Migration;
use yii\db\Schema;
use yii\db\Query;

class m160507_202611_settings extends Migration
{

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

    public function down()
    {
        echo "m160507_202611_settings cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
