<?php

use yii\db\Migration;

/**
 * Class m230517_200247_password_hash_type
 */
class m230517_200247_password_hash_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `user` ADD `password_hash_type` 
                VARCHAR(15) NOT NULL DEFAULT 'bcrypt' AFTER `password_hash`;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230517_200247_password_hash_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230517_200247_password_hash_type cannot be reverted.\n";

        return false;
    }
    */
}
