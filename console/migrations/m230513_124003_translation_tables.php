<?php

use yii\db\Migration;

/**
 * Class m230513_124003_translation_tables
 */
class m230513_124003_translation_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->execute("
        
        CREATE TABLE `source_message`
        (
           `id`          integer NOT NULL AUTO_INCREMENT PRIMARY KEY,
           `category`    varchar(255),
           `message`     text
        );

        CREATE TABLE `message`
        (
           `id`          integer NOT NULL,
           `language`    varchar(16) NOT NULL,
           `translation` text
        );

        ALTER TABLE `message` ADD CONSTRAINT `pk_message_id_language` PRIMARY KEY (`id`, `language`);
        ALTER TABLE `message` ADD CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `source_message` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE;

        CREATE INDEX idx_message_language ON message (language);
        CREATE INDEX idx_source_message_category ON source_message (category);
        
      ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230513_124003_translation_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230513_124003_translation_tables cannot be reverted.\n";

        return false;
    }
    */
}
