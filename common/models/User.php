<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

// Unit??

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * 
 * @property string $fullname
 * 
 * @property string $password_hash
 * @property string $password_hash_type
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * 
 * @property string $location
 * @property string $photo
 * @property integer $photo_approved
 * 
 * @property string $auth_key
 * @property integer $status
 * 
 * @property integer $member_since
 * @property integer $last_login_at
 * @property integer $admin
 * 
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['fullname', 'trim'],
            ['fullname', 'string', 'max' => 128],
            ['location', 'string', 'max' => 255],
            ['photo', 'string', 'max' => 255],
            ['photo_approved', 'integer'],
            ['member_since', 'integer'],
            ['last_login_at', 'integer'],
            ['admin', 'integer'],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('front.signup', 'This username has already been taken.')],
            ['username', 'string', 'min' => 5, 'max' => 255],
            ['username', 'match', 'pattern' => "/^(?=.{5,255}$)(?=[A-Za-z])[A-Za-z0-9_]+(?:\.[A-Za-z0-9]+)*$/", 'message' => Yii::t('front.signup', "The username can only contain letters from A to Z, numbers from 0 to 9, a dot (.) in the middle, and the underscore '_'.")],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('front.signup', 'This email address has already been taken.')],

            
        ];
    }
    
    public function attributeLabels(): array {
        return [
            'username'=>Yii::t('models.user.username', 'Username'),
            'fullname'=>Yii::t('models.user.fullname', 'Full name'),
            'email'=>Yii::t('models.user.email', 'Email'),
            'location'=>Yii::t('models.user.location', 'Location'),
            'photo'=>Yii::t('models.user.photo', 'Photo'),
            'photo_approved'=>Yii::t('models.user.photo_approved', 'Photo approved'),
            'status'=>Yii::t('models.user.status', 'Status'),
            'member_since'=>Yii::t('models.user.member_since', 'Member since'),
            'last_login_at'=>Yii::t('models.user.last_login_at', 'Last login'),
            'admin'=>Yii::t('models.user.admin', 'Admin'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        if ($this->password_hash_type != 'bcrypt') {
            return false;
        }
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->password_hash_type = 'bcrypt';
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function beforeValidate() {
      if (parent::beforeValidate()) {
        if (empty($this->member_since)) {
          $this->member_since= time();
        }
        
        return true;
      }
    }
    
    public function updateLastLogin() {
      $last_login_at = Yii::$app->session['last_login_at'];
      $update_period = 60 * 2; # every 2 minutes
      if (!$last_login_at || ((time() - ($last_login_at)) > $update_period)) {
        $this->touch('last_login_at');
        Yii::$app->session['last_login_at'] = $this->last_login_at;
      }
    }
}
