<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_191858_community_type extends Migration
{
    public function up()
    {
        $this->createTable('community_type', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'item_title' => Schema::TYPE_STRING . ' NOT NULL',
            'sort_key' => Schema::TYPE_INTEGER . ' DEFAULT 100 NOT NULL',
            'show_in_directory' => Schema::TYPE_BOOLEAN . ' DEFAULT 1 NOT NULL',
        ], '');

        $this->insert('community_type', [
            'id' => 1,
            'title' => 'Communities',
            'item_title' => 'Space',
            'sort_key' => 100,
            'show_in_directory' => true,
        ]);

        return true;
        
        $this->addColumn('community', 'community_type_id', Schema::TYPE_BIGINT);
        $this->update('community', ['community_type_id' => 1]);
    }

    public function down()
    {
        echo "m150924_191858_community_type cannot be reverted.\n";

        return false;
    }
}
