<?php

use yii\db\Migration;
use \yii\db\Schema;
use yii\rbac\Item;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\Module;
use zikwall\easyonline\modules\core\libs\UUID;

class m131023_164513_initial extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

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

        $this->createTable('user', [
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

        //аккаунт для администратора и права
        $this->batchInsert('{{%user}}', ['guid', 'username', 'auth_key', 'password_hash', 'email', 'status', 'created_at', 'updated_at'], [
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
        ]);

        try {
            $this->createTable('user_http_session', array(
                'id' => 'char(32) NOT NULL',
                'expire' => 'int(11) DEFAULT NULL',
                'user_id' => 'int(11) DEFAULT NULL',
                'data' => 'longblob DEFAULT NULL',
            ), '');
            $this->addPrimaryKey('pk_user_http_session', 'user_http_session', 'id');
        } catch (Exception $ex) {

        }
    }

    public function down()
    {
        echo "m131023_164513_initial does not support migration down.\n";
        return false;
    }

}
