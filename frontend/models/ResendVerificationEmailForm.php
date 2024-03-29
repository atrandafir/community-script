<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\base\Model;

class ResendVerificationEmailForm extends Model
{
    /**
     * @var string
     */
    public $email;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_INACTIVE],
                'message' => Yii::t('front.resendVerificationEmail', 'There is no user with this email address.')
            ],
        ];
    }
    
    public function attributeLabels(): array {
      return [
          'email'=>Yii::t('front.resendVerificationEmail', 'Email'),
      ];
    }

    /**
     * Sends confirmation email to user
     *
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        $user = User::findOne([
            'email' => $this->email,
            'status' => User::STATUS_INACTIVE
        ]);

        if ($user === null) {
            return false;
        }

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
