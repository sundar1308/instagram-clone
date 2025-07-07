<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $profile_image
 * @property string|null $bio
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comments[] $comments
 * @property Followers[] $followers
 * @property Followers[] $followers0
 * @property Likes[] $likes
 * @property Messages[] $messages
 * @property Messages[] $messages0
 * @property Notifications[] $notifications
 * @property Notifications[] $notifications0
 * @property Posts[] $posts
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public $nick_name;
    public $desc;

    public $authKey;
    
  


    public static function tableName()
    {
        return 'user';
    }

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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            [['bio'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'password_hash', 'profile_image'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'profile_image' => 'Profile Image',
            'bio' => 'Bio',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);  // Find user by ID
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return User::find()->where(['username' => $username])->one();
        // return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;  // User's ID
    }

    public function getAuthKey()
    {
        // return $this->auth_key;  // (if you're using auth keys)
    }

    public function validateAuthKey($authKey)
    {
        // return $this->auth_key === $authKey;
    }




    // public static function findByUsername($username)
    // {
    //     return User::find()->where(['username'=>$username])->one();
    // }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
   

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\CommentsQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Followers]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\FollowersQuery
     */
    public function getFollowers()
    {
        return $this->hasMany(Followers::class, ['follower_id' => 'id']);
    }

    /**
     * Gets query for [[Followers0]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\FollowersQuery
     */
    public function getFollowers0()
    {
        return $this->hasMany(Followers::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\LikesQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\MessagesQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Messages::class, ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications0]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\NotificationsQuery
     */
    public function getNotifications0()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\PostsQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Posts::class, ['user_id' => 'id']);
    }

    public function getBio()
    {
        return $this->bio?json_decode($this->bio, true):'';
    }
    public function getProfileImage()
    {
        return     $this->profile_image?
        Yii::getAlias('@web/web/'.$this->profile_image):
        Yii::getAlias('@web/web/images/profile_img.jpg');
    }
    public static function getAuthUserProfileImage(){
        return   Yii::$app->user->identity->profile_image?
        Yii::getAlias('@web/web/'.Yii::$app->user->identity->profile_image):
        Yii::getAlias('@web/web/images/profile_img.jpg');
    }
 
    
}
