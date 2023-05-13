<?php

use yii\db\Migration;

/**
 * Class m230513_133546_drop_translation_tables
 */
class m230513_133546_drop_translation_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->execute("
        SET FOREIGN_KEY_CHECKS=0;
        DROP TABLE `source_message`;
        DROP TABLE `message`;
      ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230513_133546_drop_translation_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230513_133546_drop_translation_tables cannot be reverted.\n";

        return false;
    }
    */
}
