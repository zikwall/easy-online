<?php

use yii\db\Schema;
use zikwall\easyonline\modules\core\components\db\Migration;

/**
 * Class m190805_074728_init_content
 */
class m190805_074728_init_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('contentcontainer', [
                'id' => Schema::TYPE_PK,
                'guid' => Schema::TYPE_STRING,
                'class' => Schema::TYPE_STRING,
                'pk' => Schema::TYPE_INTEGER,
                'owner_user_id' => Schema::TYPE_INTEGER,
                'wall_id' => Schema::TYPE_INTEGER,
            ]
            , '');

        $this->createIndex('unique_target', 'contentcontainer', ['class', 'pk'], true);
        $this->createIndex('unique_guid', 'contentcontainer', ['guid'], true);

        /*$users = (new \yii\db\Query())->select("user.*")->from('user');

        foreach ($users->each() as $user) {
            $this->insertSilent('contentcontainer', [
                'guid' => $user['guid'],
                'class' => \zikwall\easyonline\modules\user\models\User::class,
                'pk' => $user['id'],
                'owner_user_id' => $user['id'],
                'wall_id' => $user['wall_id'],
            ]);

            $this->updateSilent('user', ['contentcontainer_id' => Yii::$app->db->getLastInsertID()], 'user.id=:userId', [':userId' => $user['id']]);
        }*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_074728_init_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_074728_init_content cannot be reverted.\n";

        return false;
    }
    */
}
