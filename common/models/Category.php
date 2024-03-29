<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Post[] $posts
 */
class Category extends \yii\db\ActiveRecord {

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return '{{%category}}';
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
        [['name'], 'required'],
        [['created_at', 'updated_at'], 'integer'],
        [['name'], 'string', 'max' => 128],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
        'id' => 'ID',
        'name' => Yii::t('models.category', 'Name'),
        'created_at' => Yii::t('models.category','Created At'),
        'updated_at' => Yii::t('models.category','Updated At'),
    ];
  }

  /**
   * Gets query for [[Posts]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getPosts() {
    return $this->hasMany(Post::class, ['category_id' => 'id']);
  }

}
