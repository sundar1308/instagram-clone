<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $content
 * @property string $created_at
 * @property string|null $read_at
 *
 * @property Conversations[] $conversations
 * @property User $receiver
 * @property User $sender
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'content'], 'required'],
            [['sender_id', 'receiver_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'read_at'], 'safe'],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender ID',
            'receiver_id' => 'Receiver ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'read_at' => 'Read At',
        ];
    }

    /**
     * Gets query for [[Conversations]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\ConversationsQuery
     */
    public function getConversations()
    {
        return $this->hasMany(Conversations::class, ['last_message_id' => 'id']);
    }

    /**
     * Gets query for [[Receiver]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::class, ['id' => 'receiver_id']);
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

    /**
     * {@inheritdoc}
     * @return \app\models\query\MessagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MessagesQuery(get_called_class());
    }
}
