<?php

use yii\db\Schema;
use yii\db\Migration;

class m160205_203913_foreign_keys extends Migration
{
    public function up()
    {
        return true;
        
        try {
            $this->addForeignKey('fk_community_membership-user_id', 'community_membership', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }

        try {
            $this->addForeignKey('fk_community_membership-community_id', 'community_membership', 'community_id', 'community', 'id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }

        try {
            $this->alterColumn('community_module', 'community_id', $this->integer()->null());
            $this->update('community_module', ['community_id' => new yii\db\Expression('NULL')], ['community_id' => 0]);
            $this->addForeignKey('fk_community_module-community_id', 'community_module', 'community_id', 'community', 'id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }

        try {
            $this->addForeignKey('fk_community-wall_id', 'community', 'wall_id', 'wall', 'id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }

        try {
            $this->addForeignKey('fk_community_module-module_id', 'community_module', 'module_id', 'module_enabled', 'module_id', 'CASCADE', 'CASCADE');
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_community_membership-user_id', 'community_membership');
        $this->dropForeignKey('fk_community_membership-community_id', 'community_membership');
        $this->dropForeignKey('fk_community_module-community_id', 'community_module');
        $this->dropForeignKey('fk_community-wall_id', 'community');
        $this->dropForeignKey('fk_community_module-module_id', 'community_module');

        return true;
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
