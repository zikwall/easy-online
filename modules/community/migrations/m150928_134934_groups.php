<?php

use yii\db\Schema;
use yii\db\Migration;

class m150928_134934_groups extends Migration
{
    public function up()
    {
        return true;
        
        $this->addColumn('community_membership', 'group_id', Schema::TYPE_STRING. " DEFAULT 'member'");
        $this->update('community_membership', ['group_id' => 'admin'], 'community_membership.admin_role=1');
        
        /*$this->dropColumn('community_membership', 'admin_role');
        $this->dropColumn('community_membership', 'share_role');
        $this->dropColumn('community_membership', 'invite_role');*/
    }

    public function down()
    {
        echo "m150928_134934_groups cannot be reverted.\n";
        return false;
    }
}
