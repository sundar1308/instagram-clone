<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property int|null $post_id
 * @property int|null $sender_id
 * @property string $message
 * @property string $created_at
 * @property string|null $read_at
 *
 * @property Posts $post
 * @property User $sender
 * @property User $user
 */
class Notifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'message'], 'required'],
            [['message'], 'string'],
            [['created_at', 'read_at'], 'safe'],
            [['type'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['post_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
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
            'type' => 'Type',
            'post_id' => 'Post ID',
            'sender_id' => 'Sender ID',
            'message' => 'Message',
            'created_at' => 'Created At',
            'read_at' => 'Read At',
        ];
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
     * Gets query for [[Sender]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'sender_id']);
    }

    public function getIsFollowing()
    {
        return $this->hasOne(Followers::class, ['follower_id' => 'sender_id']);
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
     * @return \app\models\query\NotificationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\NotificationsQuery(get_called_class());
    }
    // public function isFollowing()
    // {
    //     return Followers::find()->where([
    //         'follower_id'=>$this->sender_id
    //     ])->one();
    // }
    public static function createNotification($userId, $senderId, $type, $message)
    {
        $notification = new self();
        $notification->user_id = $userId;
        $notification->sender_id = $senderId;
        $notification->type = $type;
        $notification->message = $message;
        $notification->read_at = null; // unread by default
        $notification->created_at = date('Y-m-d H:i:s');
        return $notification->save();
    }

}
