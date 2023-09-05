<?php

use yii\base\Security;
use yii\db\Migration;

/**
 * Class m230904_160720_seed_demo_user
 */
class m230904_160720_seed_demo_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $security = new Security();

        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => $security->generatePasswordHash('123456'),
            'auth_key' => 'absd',
            'email' => 'test@gmail.com',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230904_160720_seed_demo_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230904_160720_seed_demo_user cannot be reverted.\n";

        return false;
    }
    */
}
