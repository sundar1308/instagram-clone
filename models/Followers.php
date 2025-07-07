<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "followers".
 *
 * @property int $id
 * @property int $user_id
 * @property int $follower_id
 * @property string $created_at
 *
 * @property User $follower
 * @property User $user
 */
class Followers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'followers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'follower_id'], 'required'],
            [['user_id', 'follower_id'], 'integer'],
            [['created_at'], 'safe'],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['follower_id' => 'id']],
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
            'follower_id' => 'Follower ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Follower]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getFollower()
    {
        return $this->hasOne(User::class, ['id' => 'follower_id']);
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
     * @return \app\models\query\FollowersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FollowersQuery(get_called_class());
    }
}
