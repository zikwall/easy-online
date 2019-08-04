<?php

use yii\db\Migration;

class uninstall extends Migration
{
    public function up()
    {
        //$this->dropForeignKey('fk_community_membership-user_id', 'community_membership');
        //$this->dropForeignKey('fk_community_membership-community_id', 'community_membership');
        //$this->dropForeignKey('fk_community_module-community_id', 'community_module');
        //$this->dropForeignKey('fk_community-wall_id', 'community');
        //$this->dropForeignKey('fk_community_module-module_id', 'community_module');

        //$this->dropTable('community');
        //$this->dropTable('community_module');
        $this->dropTable('community_type');
        //$this->dropTable('community_membership');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }
}
