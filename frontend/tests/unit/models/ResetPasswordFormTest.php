<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use frontend\models\ResetPasswordForm;

class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    public function testResetWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new ResetPasswordForm($user['password_reset_token']);
        verify($form->resetPassword())->notEmpty();
    }
    
    public function testMd5ToBcryptAfterReset() {
      
      /** @var \common\models\User $user */
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      $form = new ResetPasswordForm($user->password_reset_token);
      $form->password='new_password';
      verify($form->resetPassword())->notEmpty();
      
      // reload user
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      // verify now password hash type has been changed
      verify($user->password_hash_type)->equals('bcrypt');
      
      // verify user pwd can be validated
      verify($user->validatePassword($form->password))->true();
      
    }

}
