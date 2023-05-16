<?php

use yii\db\Migration;

/**
 * Class m230516_102641_user_extra_fields
 */
class m230516_102641_user_extra_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->execute("
      
        ALTER TABLE `user` 
          ADD `fullname` VARCHAR(128) NULL AFTER `username`;
          
        ALTER TABLE `user` 
          ADD `member_since` DATETIME NULL AFTER `status`, 
          ADD `last_login` DATETIME NULL AFTER `member_since`, 
          ADD `admin` TINYINT(1) NOT NULL DEFAULT '0' AFTER `last_login`;
          
        ALTER TABLE `user` 
          ADD `location` VARCHAR(128) NULL AFTER `email`, 
          ADD `photo` VARCHAR(255) NULL AFTER `location`, 
          ADD `photo_approved` TINYINT(1) NOT NULL DEFAULT '0' AFTER `photo`;
          
        ALTER TABLE `user` 
          CHANGE `member_since` `member_since` INT(11) NULL DEFAULT NULL, 
          CHANGE `last_login` `last_login_at` INT NULL DEFAULT NULL;



      ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230516_102641_user_extra_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230516_102641_user_extra_fields cannot be reverted.\n";

        return false;
    }
    */
}
