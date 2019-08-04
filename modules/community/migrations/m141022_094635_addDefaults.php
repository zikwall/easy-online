<?php

use yii\db\Migration;

class m141022_094635_addDefaults extends Migration
{
    public function up()
    {
        return true;
        
        $this->insert('setting', ['name'=>'defaultVisibility', 'module_id'=>'community', 'value'=>'1']);
        $this->insert('setting', ['name'=>'defaultJoinPolicy', 'module_id'=>'community', 'value'=>'1']);
    }

    public function down()
    {
        echo "m141022_094635_addDefaults does not support migration down.\n";
        return false;
    }
}
