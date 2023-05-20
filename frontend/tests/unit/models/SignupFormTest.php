<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use frontend\models\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
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
            ]
        ]);
    }

    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'password' => 'some_password',
        ]);

        $user = $model->signup();
        verify($user)->notEmpty();

        /** @var \common\models\User $user */
        $user = $this->tester->grabRecord('common\models\User', [
            'username' => 'some_username',
            'email' => 'some_email@example.com',
            'status' => \common\models\User::STATUS_INACTIVE
        ]);

        $this->tester->seeEmailIsSent();

        $mail = $this->tester->grabLastSentEmail();

        verify($mail)->instanceOf('yii\mail\MessageInterface');
        verify($mail->getTo())->arrayHasKey('some_email@example.com');
        verify($mail->getFrom())->arrayHasKey(\Yii::$app->params['senderEmail']);
        verify($mail->getSubject())->equals('Account registration at ' . \Yii::$app->name);
        verify($mail->toString())->stringContainsString($user->verification_token);
    }

    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',
            'email' => 'nicolas.dianna@hotmail.com',
            'password' => 'some_password',
        ]);

        verify($model->signup())->empty();
        verify($model->getErrors('username'))->notEmpty();
        verify($model->getErrors('email'))->notEmpty();

        verify($model->getFirstError('username'))
            ->equals('This username has already been taken.');
        verify($model->getFirstError('email'))
            ->equals('This email address has already been taken.');
    }

    public function testValidAndInvalidUsernames()
    {
        foreach ([
          'john__doe'=>'valid',
          'john_doe'=>'valid',
          'john.doe'=>'valid',
          'john.doe78'=>'valid',
          'johndoe.'=>'invalid',
          '.johndoe'=>'invalid',
          '4johndoe'=>'invalid',
          'johndoe$'=>'invalid',
        ] as $username => $result) {
          
          
          
          $model = new SignupForm([
            'username' => $username,
            'email' => "{$username}@hotmail.com",
            'password' => 'some_password',
          ]);
            
          try {
            
            if ($result=='valid') {
              verify($model->signup())->notEmpty();
              verify($model->getErrors('username'))->empty();
            } elseif ($result=='invalid') {
              verify($model->signup())->empty();
              verify($model->getErrors('username'))->notEmpty();
            }
            
          } catch (\Throwable $t) {
            $this->fail("{$username} {$result} FALIED.");
//            fwrite(STDERR, print_r($username, true));
//            throw $t;
          }

          
          
        }
    }
}
