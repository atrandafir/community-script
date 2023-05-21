<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $post_id
 * @property int|null $author_id
 * @property string|null $fullname
 * @property string|null $email
 * @property string $comment
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property Post $post
 */
class Comment extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return '{{%comment}}';
  }

  /**
   * {@inheritdoc}
   */
  public function behaviors() {
    return [
        TimestampBehavior::class,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function rules() {
    return [
        [['post_id', 'comment'], 'required'],
        [['post_id', 'author_id', 'created_at', 'updated_at'], 'integer'],
        [['comment'], 'string'],
        [['fullname'], 'string', 'max' => 128],
        [['email'], 'string', 'max' => 255],
        [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['post_id' => 'id']],
        [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
        'id' => 'ID',
        'post_id' => 'Post ID',
        'author_id' => 'Author ID',
        'fullname' => 'Fullname',
        'email' => 'Email',
        'comment' => 'Comment',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ];
  }

  /**
   * Gets query for [[Author]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getAuthor() {
    return $this->hasOne(User::class, ['id' => 'author_id']);
  }

  /**
   * Gets query for [[Post]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getPost() {
    return $this->hasOne(Post::class, ['id' => 'post_id']);
  }

}
