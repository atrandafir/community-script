<?php

use yii\db\Migration;

/**
 * Class m230521_124825_initial_models
 */
class m230521_124825_initial_models extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->execute("

        CREATE TABLE `category` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `name` VARCHAR(128) NOT NULL , 
          `created_at` INT NULL , 
          `updated_at` INT NULL , 
          PRIMARY KEY (`id`)) 
        ENGINE = InnoDB;
        
        CREATE TABLE `post` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `category_id` INT NOT NULL , 
          `author_id` INT NOT NULL , 
          `response_to_id` INT NULL , 
          `title` VARCHAR(255) NOT NULL , 
          `body` TEXT NULL , 
          `view_count` INT NOT NULL DEFAULT '0' , 
          `created_at` INT NULL , 
          `updated_at` INT NULL , 
          PRIMARY KEY (`id`), 
          INDEX (`category_id`), 
          INDEX (`author_id`), 
          INDEX (`response_to_id`)) 
        ENGINE = InnoDB;
        
        ALTER TABLE `post` 
          ADD FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) 
            ON DELETE RESTRICT ON UPDATE RESTRICT; 
        ALTER TABLE `post` 
          ADD FOREIGN KEY (`author_id`) REFERENCES `user`(`id`) 
            ON DELETE CASCADE ON UPDATE RESTRICT; 
        ALTER TABLE `post` 
          ADD FOREIGN KEY (`response_to_id`) REFERENCES `post`(`id`) 
            ON DELETE SET NULL ON UPDATE RESTRICT;

        CREATE TABLE `comment` ( 
          `id` INT NOT NULL AUTO_INCREMENT , 
          `post_id` INT NOT NULL , 
          `author_id` INT NULL , 
          `fullname` VARCHAR(128) NULL , 
          `email` VARCHAR(255) NULL , 
          `comment` TEXT NOT NULL , 
          `created_at` INT NULL , 
          `updated_at` INT NULL , 
          PRIMARY KEY (`id`), 
          INDEX (`post_id`), 
          INDEX (`author_id`)) 
        ENGINE = InnoDB;
        
        ALTER TABLE `comment` 
          ADD FOREIGN KEY (`post_id`) REFERENCES `post`(`id`) 
            ON DELETE CASCADE ON UPDATE RESTRICT; 
        ALTER TABLE `comment` 
          ADD FOREIGN KEY (`author_id`) REFERENCES `user`(`id`) 
            ON DELETE CASCADE ON UPDATE RESTRICT;


      ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230521_124825_initial_models cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230521_124825_initial_models cannot be reverted.\n";

        return false;
    }
    */
}
