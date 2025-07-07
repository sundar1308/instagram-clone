<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "conversations".
 *
 * @property int $id
 * @property int $user1_id
 * @property int $user2_id
 * @property int|null $last_message_id
 * @property string $created_at
 *
 * @property Messages $lastMessage
 * @property User $user1
 * @property User $user2
 */
class Conversations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user1_id', 'user2_id'], 'required'],
            [['user1_id', 'user2_id', 'last_message_id'], 'integer'],
            [['created_at'], 'safe'],
            [['last_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Messages::class, 'targetAttribute' => ['last_message_id' => 'id']],
            [['user1_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user1_id' => 'id']],
            [['user2_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user2_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user1_id' => 'User1 ID',
            'user2_id' => 'User2 ID',
            'last_message_id' => 'Last Message ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[LastMessage]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\MessagesQuery
     */
    public function getLastMessage()
    {
        return $this->hasOne(Messages::class, ['id' => 'last_message_id']);
    }

    /**
     * Gets query for [[User1]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getUser1()
    {
        return $this->hasOne(User::class, ['id' => 'user1_id']);
    }

    /**
     * Gets query for [[User2]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getUser2()
    {
        return $this->hasOne(User::class, ['id' => 'user2_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ConversationsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ConversationsQuery(get_called_class());
    }
}
