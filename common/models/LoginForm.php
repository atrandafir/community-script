<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    
    public $is_backend = false;

    /**
     * @var User
     */
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels(): array {
        return [
            'username'=>Yii::t('front.login', 'Username or email'),
            'password'=>Yii::t('front.login', 'Password'),
            'rememberMe'=>Yii::t('front.login', 'Remember me'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $this->checkOldPasswordHash($user);
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('front.login', 'Incorrect username or password.'));
            }
        }
    }

    private function checkOldPasswordHash($user) {
        /** @var \common\models\User $user */
        if (!$user) return;
        if ($user->password_hash_type=='md5') {
            if ($user->password_hash==md5($this->password)) {
                $user->setPassword($this->password);
                $user->update($runValidation = false, $attributeNames = ['password_hash','password_hash_type']);
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user=$this->getUser();
            $user->updateLastLogin(); 
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->username);
        }
        
        // check admin
        if ($this->is_backend && !$this->_user->admin) {
          return null;
        }

        return $this->_user;
    }
}
