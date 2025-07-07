<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property int $user_id
 * @property string $image_path
 * @property string|null $caption
 * @property string $created_at
 *
 * @property Comments[] $comments
 * @property Likes[] $likes
 * @property Notifications[] $notifications
 * @property User $user
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */

     public function beforeSave($insert)
     {
         if ($this->isNewRecord) {
             // Generate UUID for new comments
             if (empty($this->uuid)) {
                 $this->uuid = Yii::$app->security->generateRandomString(6); // Or use the UUID library
             }
         }
         return parent::beforeSave($insert);
     }


    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['caption'], 'string'],
            [['created_at'], 'safe'],
            [['image_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'caption' => 'Caption',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CommentsQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\LikesQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['post_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\PostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PostsQuery(get_called_class());
    }
}
