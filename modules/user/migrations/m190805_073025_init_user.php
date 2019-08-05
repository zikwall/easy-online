<?php

use yii\db\Migration;
use \yii\db\Schema;
use yii\rbac\Item;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\Module;
use zikwall\easyonline\modules\core\libs\UUID;

/**
 * Class m190805_075025_init_user
 */
class m190805_073025_init_user extends \zikwall\easyonline\modules\core\components\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%group}}', [
            'id' => 'pk',
            'community_id' => 'int(10) DEFAULT NULL',
            'name' => 'varchar(45) DEFAULT NULL',
            'description' => 'text DEFAULT NULL',
            'created_at' => 'int(11) DEFAULT NULL',
            'created_by' => 'int(11) DEFAULT NULL',
        ], '');

        $this->addColumn('group', 'is_admin_group', Schema::TYPE_BOOLEAN. ' NOT NULL DEFAULT 0');
        $this->addColumn('group', 'show_at_registration', Schema::TYPE_BOOLEAN. ' NOT NULL DEFAULT 1');
        $this->addColumn('group', 'show_at_directory', Schema::TYPE_BOOLEAN. ' NOT NULL DEFAULT 1');

        // Create initial administration group
        $this->insertSilent('group', [
            'name' => 'Administrator',
            'description' => 'Administrator Group',
            'is_admin_group' => '1',
            'show_at_registration' => '0',
            'show_at_directory' => '0',
            'created_at' => time()
        ]);
        
        $this->createTable('profile', [
            'user_id' => $this->integer()->notNull(),
        ], '');

        $this->addPrimaryKey('pk_profile', 'profile', 'user_id');

        $this->createTable('profile_field', [
            'id' => $this->primaryKey(),
            'profile_field_category_id' => 'int(11) NOT NULL',
            'module_id' => 'varchar(255) DEFAULT NULL',
            'field_type_class' => 'varchar(255) NOT NULL',
            'field_type_config' => 'text DEFAULT NULL',
            'internal_name' => 'varchar(100) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'description' => 'text DEFAULT NULL',
            'sort_order' => 'int(11) NOT NULL DEFAULT \'100\'',
            'required' => 'tinyint(4) DEFAULT NULL',
            'show_at_registration' => 'tinyint(4) DEFAULT NULL',
            'editable' => 'tinyint(4) NOT NULL DEFAULT \'1\'',
            'visible' => 'tinyint(4) NOT NULL DEFAULT \'1\'',
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
        ], '');

        $this->createTable('profile_field_category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => 'text NOT NULL',
            'sort_order' => $this->integer(11)->notNull()->defaultValue(100),
            'module_id' => $this->integer()->null(),
            'visibility' => 'tinyint(4) NOT NULL DEFAULT \'1\'',
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
        ], '');

        $this->addColumn('profile_field', 'translation_category', 'varchar(255) DEFAULT NULL');
        $this->addColumn('profile_field', 'is_system', 'int(1) DEFAULT NULL');
        $this->addColumn('profile_field', 'ldap_attribute', 'string');
        $this->addColumn('profile_field_category', 'translation_category', 'varchar(255) DEFAULT NULL');
        $this->addColumn('profile_field_category', 'is_system', 'int(1) DEFAULT NULL');

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'guid' => $this->string(45)->null(),
            'status' => 'tinyint(4) NOT NULL DEFAULT \'2\'',
            'username' =>  $this->string(25)->null(),
            'email' => $this->string()->null(),
            'auth_mode' =>  $this->string(10)->notNull(),
            'tags' => $this->text()->null(),
            'language' =>  $this->string(5)->null(),
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
            'last_login' => $this->dateTime()->null(),
            'visibility' => $this->integer(1)->defaultValue(1),
            'time_zone' => $this->string(100)->null()
        ], '');

        $this->addColumn('user', 'contentcontainer_id', Schema::TYPE_INTEGER);

        $this->createTable('user_follow', [
            'user_follower_id' => 'int(11) NOT NULL',
            'user_followed_id' => 'int(11) NOT NULL',
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
        ], '');

        $this->addPrimaryKey('pk_user_follow', 'user_follow', [
            'user_follower_id', 'user_followed_id'
        ]);

        $this->createTable('user_module', [
            'id' => $this->primaryKey(),
            'module_id' => $this->string(255)->notNull(),
            'user_id' => $this->integer(11)->notNull(),
            'state' => $this->integer(4),
        ], '');

        $this->createTable('group_permission', [
            'permission_id' => $this->string(150)->notNull(),
            'group_id' => $this->integer(),
            'module_id' => $this->string(50)->notNull(),
            'class' => $this->string(),
            'state' => $this->boolean(),
        ]);

        $this->addPrimaryKey('permission_pk', 'group_permission', [
            'permission_id', 'group_id', 'module_id'
        ]);

        $this->createTable('group_user', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'group_id' => $this->integer(11)->notNull(),
            'is_group_manager' => 'tinyint(1) NOT NULL DEFAULT 0',
            'created_at' => $this->dateTime()->null(),
            'created_by' => $this->integer(11)->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer(11)->null(),
        ]);

        $this->createTable('{{%user_friendship}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'friend_user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('idx-friends', 'user_friendship', ['user_id', 'friend_user_id'], true);
        $this->addForeignKey('fk-user', 'user_friendship', 'user_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-friend', 'user_friendship', 'friend_user_id', 'user', 'id', 'CASCADE');

        //аккаунт для администратора и права
        /*$this->batchInsert('{{%user}}', ['guid', 'username', 'auth_key', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], [
            [
                UUID::v4(),
                \Yii::t('UserModule.users', 'administrator'),
                \Yii::$app->security->generateRandomString(),
                \Yii::$app->security->generatePasswordHash('administrator@easyonline.com'),
                'administrator@easyonline.com',
                User::STATUS_ACTIVE,
                time(),
                time()
            ],
            [
                UUID::v4(),
                \Yii::t('UserModule.users', 'moderator'),
                \Yii::$app->security->generateRandomString(),
                \Yii::$app->security->generatePasswordHash('moderator@easyonline.com'),
                'moderator@easyonline.com',
                User::STATUS_ACTIVE,
                time(),
                time()
            ]
        ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_075025_init_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_075025_init_user cannot be reverted.\n";

        return false;
    }
    */
}
