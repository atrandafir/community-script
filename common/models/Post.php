<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $author_id
 * @property int|null $response_to_id
 * @property string $title
 * @property string|null $body
 * @property int $view_count
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $author
 * @property Category $category
 * @property Comment[] $comments
 * @property Post[] $responses
 * @property Post $responseTo
 */
class Post extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return '{{%post}}';
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
        [['category_id', 'author_id', 'title'], 'required'],
        [['category_id', 'author_id', 'response_to_id', 'view_count', 'created_at', 'updated_at'], 'integer'],
        [['body'], 'string'],
        [['title'], 'string', 'max' => 255],
        [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
        [['response_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::class, 'targetAttribute' => ['response_to_id' => 'id']],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
        'id' => 'ID',
        'category_id' => 'Category ID',
        'author_id' => 'Author ID',
        'response_to_id' => 'Response To ID',
        'title' => 'Title',
        'body' => 'Body',
        'view_count' => 'View Count',
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
   * Gets query for [[Category]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCategory() {
    return $this->hasOne(Category::class, ['id' => 'category_id']);
  }

  /**
   * Gets query for [[Comments]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getComments() {
    return $this->hasMany(Comment::class, ['post_id' => 'id']);
  }

  /**
   * Gets query for [[Responses]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getResponses() {
    return $this->hasMany(Post::class, ['response_to_id' => 'id']);
  }

  /**
   * Gets query for [[ResponseTo]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getResponseTo() {
    return $this->hasOne(Post::class, ['id' => 'response_to_id']);
  }

}
