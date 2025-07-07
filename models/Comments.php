<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property string $created_at
 * @property int|null $parent_comment_id
 *
 * @property Comments[] $comments
 * @property Comments $parentComment
 * @property Posts $post
 * @property User $user
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public const All_Comments='';
    public static function tableName()
    {
        return 'comments';
    }
    
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            // Generate UUID for new comments
            if (empty($this->uuid)) {
                $this->uuid = Yii::$app->security->generateRandomString(6); 
            }
        }
        return parent::beforeSave($insert);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'user_id', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['post_uuid' => 'uuid']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_uuid' => 'uuid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'parent_comment_id' => 'Parent Comment ID',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CommentsQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['parent_comment_id' => 'id']);
    }

    /**
     * Gets query for [[ParentComment]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CommentsQuery
     */
    public function getParentComment()
    {
        return $this->hasOne(Comments::class, ['id' => 'parent_comment_id']);
    }

    public function getLikes()
    {
        return $this->hasMany(CommentLikes::class, ['comment_id' => 'id']);
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostsQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['id' => 'post_id']);
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
     * @return \app\models\query\CommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CommentsQuery(get_called_class());
    }
}
