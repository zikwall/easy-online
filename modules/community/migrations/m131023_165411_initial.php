<?php


use yii\db\Migration;

class m131023_165411_initial extends Migration
{
    public function up()
    {
        return true;
        
        $this->createTable('community', [
            'id' => 'pk',
            'guid' => 'varchar(45) DEFAULT NULL',
            'name' => 'varchar(45) NOT NULL',
            'description' => 'text DEFAULT NULL',
            'join_policy' => 'tinyint(4) DEFAULT NULL',
            'visibility' => 'tinyint(4) DEFAULT NULL',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\'',
            'tags' => 'text DEFAULT NULL',
            'created_at' => 'datetime DEFAULT NULL',
            'created_by' => 'int(11) DEFAULT NULL',
            'updated_at' => 'datetime DEFAULT NULL',
            'updated_by' => 'int(11) DEFAULT NULL',
        ], '');

        $this->addColumn('community', 'members_can_leave', Schema::TYPE_INTEGER. ' DEFAULT 1');
        $this->addColumn('community', 'auto_add_new_members', 'int(4) DEFAULT NULL');
        $this->addColumn('community', 'default_content_visibility', Schema::TYPE_BOOLEAN);
        $this->addColumn('community', 'color', 'varchar(7)');

        $this->createTable('community_membership', [
            'community_id' => 'int(11) NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'originator_user_id' => 'varchar(45) DEFAULT NULL',
            'status' => 'tinyint(4) DEFAULT NULL',
            'request_message' => 'text DEFAULT NULL',
            'last_visit' => 'datetime DEFAULT NULL',
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
            'group_id' => $this->string()->defaultValue('member'),
            'show_at_dashboard' => $this->boolean()->defaultValue(1),
            'can_cancel_membership' => $this->integer()->defaultValue(1),
            'send_notifications' => $this->boolean()->defaultValue(0),
        ], '');

        $this->addColumn('community_membership', 'show_at_dashboard', Schema::TYPE_BOOLEAN. ' DEFAULT 1');

        $this->addPrimaryKey('pk_community_membership', 'community_membership', 'user_id, community_id');

        $this->createTable('community_module', [
            'id' => 'pk',
            'module_id' => 'varchar(255) NOT NULL',
            'community_id' => 'int(11) NOT NULL',
            'state' => 'int(4)'
        ], '');
    }

    public function down()
    {
        echo "m131023_165411_initial does not support migration down.\n";
        return false;
    }
}