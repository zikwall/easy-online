<?php


use yii\db\Migration;

class m131213_165552_user_optimize extends Migration
{

    public function up()
    {
        $this->createIndex('unique_email', 'user', 'email', true);
        $this->createIndex('unique_username', 'user', 'username', true);
        $this->createIndex('unique_guid', 'user', 'guid', true);
        $this->createIndex('index_profile_field_category', 'profile_field', 'profile_field_category_id', false);
        $this->createIndex('index_user_module', 'user_module', 'user_id, module_id', true);
    }

    public function down()
    {

        return true;
    }

}
