<?php

namespace common\tests\unit\models;

use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        verify($model->login())->false();
        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);

        verify($model->login())->false();
        verify( $model->errors)->arrayHasKey('password');
        verify(Yii::$app->user->isGuest)->true();
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        verify($model->login())->true();
        verify($model->errors)->arrayHasNotKey('password');
        verify(Yii::$app->user->isGuest)->false();
    }

    public function testLoginCorrectWithEmail()
    {
        $model = new LoginForm([
            'username' => 'nicole.paucek@schultz.info',
            'password' => 'password_0',
        ]);

        verify($model->login())->true();
        verify($model->errors)->arrayHasNotKey('password');
        verify(Yii::$app->user->isGuest)->false();
    }
    
    public function testBackofficeAdminLoginWrong() {
      
      $model = new LoginForm([
          'username' => 'bayer.hudson',
          'password' => 'password_0',
      ]);
      
      $model->is_backend = true;
      
      verify($model->login())->false();
      verify( $model->errors)->arrayHasKey('password');
      verify(Yii::$app->user->isGuest)->true();
      
    }
    
    public function testBackofficeAdminLoginCorrect() {
      
      $model = new LoginForm([
          'username' => 'webmaster',
          'password' => 'password_0',
      ]);
      
      $model->is_backend = true;

      verify($model->login())->true();
      verify($model->errors)->arrayHasNotKey('password');
      verify(Yii::$app->user->isGuest)->false();
    }
    
    public function testLoginOldMd5User() {
      
      $credentials=[
          'username' => 'mymd5user',
          'password' => 'mymd5password',
      ];
      
      /** @var \common\models\User $user */
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      // check currently is using md5
      verify($user->password_hash_type)->equals('md5');
      
      $model = new LoginForm($credentials);

      // verify it logs in
      verify($model->login())->true();
      verify($model->errors)->arrayHasNotKey('password');
      verify(Yii::$app->user->isGuest)->false();
      
      // reload user
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      // verify now password hash type has been changed
      verify($user->password_hash_type)->equals('bcrypt');
      
      // verify user pwd can be validated
      verify($user->validatePassword($credentials['password']))->true();
      
    }
    
    public function testLastLoginIsUpdated() {
      
      $credentials=[
          'username' => 'mymd5user',
          'password' => 'mymd5password',
      ];
      
      /** @var \common\models\User $user */
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      $last_login_at=$user->last_login_at;
      
      $model = new LoginForm($credentials);

      // verify it logs in
      verify($model->login())->true();
      verify($model->errors)->arrayHasNotKey('password');
      verify(Yii::$app->user->isGuest)->false();
      
      // reload user
      $user = $this->tester->grabRecord('common\models\User', [
          'username' => 'mymd5user',
      ]);
      
      // verify now last_login_at has been changed
      verify($user->last_login_at)->notEquals($last_login_at);
    }
    
//    public function testLastLoginIsUpdated() {
//      $this->fail("not implemented");
//    }
}
