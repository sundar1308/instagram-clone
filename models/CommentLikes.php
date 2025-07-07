<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment_likes".
 *
 * @property int $id
 * @property int $comment_id
 * @property int $user_id
 * @property string $created_at
 *
 * @property Comments $comment
 * @property User $user
 */
class CommentLikes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment_likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_id', 'user_id'], 'required'],
            [['comment_id', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::class, 'targetAttribute' => ['comment_id' => 'id']],
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
            'comment_id' => 'Comment ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Comment]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CommentsQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comments::class, ['id' => 'comment_id']);
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
     * @return \app\models\query\CommentLikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CommentLikesQuery(get_called_class());
    }
}
