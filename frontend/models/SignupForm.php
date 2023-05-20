<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\helpers\Tools;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $fullname;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],

            ['email', 'trim'],
            ['email', 'required'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            
            ['fullname', 'trim'],
            ['fullname', 'string', 'max' => 128],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('front.signup', 'Username'),
            'fullname' => Yii::t('front.signup', 'Full name'),
            'email' => Yii::t('front.signup', 'Email'),
            'password' => Yii::t('front.signup', 'Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->fullname = $this->fullname;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        
        if (!$user->validate()) {
            Tools::copyErrors($user, $this);
            return null;
        }

        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html'],
                ['user' => $user]
            )
            ->setTo($this->email)
            ->setSubject(Yii::t('front.signup.email', 'Account registration at {site_name}', [
                'site_name'=>Yii::$app->name,
            ]))
            ->send();
    }
}
