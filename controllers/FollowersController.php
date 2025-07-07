<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Controller;
use app\models\Followers;
use app\components\Utility;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;


class FollowersController extends Controller
{
    public $cacheDuration = 2;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['followstatus', 'getfollowers', 'getfollowing', 'removefollowing', 'removefollower'],  // Allow all actions
                        'roles' => ['@'],    // Authenticated users (logged in)
                    ],
                    [
                        'allow' => false, // Deny access for guests (not authenticated users)
                        'roles' => ['?'],  // Guests (not logged in)
                    ],
                ],
            ],
        ];
    }


    public function actionGetfollowers($id, $offset, $limit)
    {

        //  Auth user Follower

        // SELECT
        //     `user`.id AS uid,
        //     `user`.username,
        //     `user`.`profile_image`,
        //     `user`.bio,
        //     `user`.`created_at`,
        //     COUNT(DISTINCT followers1.user_id) AS followers_count,
        //     COUNT(DISTINCT followers2.user_id) AS following_count
        // FROM
        //     `user`
        // LEFT JOIN followers AS followers1 ON followers1.follower_id = `user`.id  -- Count users following this user
        // LEFT JOIN followers AS followers2 ON followers2.user_id = `user`.id  -- Count users this user is following
        // WHERE
        //     followers2.follower_id = 2  -- Only interested in users where user_id = 4 follows the `user`
        // GROUP BY
        //     `user`.id, `user`.username, `user`.profile_image, `user`.bio, `user`.created_at;




        //     SELECT
        //     `user`.id AS uid,
        //     `user`.username,
        //     `user`.`profile_image`,
        //     `user`.bio,
        //     `user`.`created_at`,
        //    (SELECT COUNT(followers.user_id) FROM followers WHERE followers.follower_id=uid) AS followers_count,
        //       (SELECT COUNT(followers.user_id) FROM followers WHERE followers.user_id=uid) AS following_count
        // FROM
        //     `user`
        // JOIN followers ON user.id = followers.user_id and followers.follower_id = 4


        // Auth user following


        // SELECT
        //     `user`.id AS uid,
        //     `user`.username,
        //     `user`.`profile_image`,
        //     `user`.bio,
        //     `user`.`created_at`,
        //     COUNT(DISTINCT followers1.user_id) AS followers_count,
        //     COUNT(DISTINCT followers2.user_id) AS following_count
        // FROM
        //     `user`
        // LEFT JOIN followers AS followers1 ON followers1.follower_id = `user`.id  -- Count users following this user
        // LEFT JOIN followers AS followers2 ON followers2.user_id = `user`.id  -- Count users this user is following
        // WHERE
        //     followers1.user_id = 2  -- Only interested in users where user_id = 4 follows the `user`
        // GROUP BY
        //     `user`.id, `user`.username, `user`.profile_image, `user`.bio, `user`.created_at;



        //     SELECT
        //     `user`.id AS uid,
        //     `user`.username,
        //     `user`.`profile_image`,
        //     `user`.bio,
        //     `user`.`created_at`,
        //    (SELECT COUNT(followers.user_id) FROM followers WHERE followers.follower_id=uid) AS followers_count,
        //       (SELECT COUNT(followers.user_id) FROM followers WHERE followers.user_id=uid) AS following_count
        // FROM
        //     `user`
        // JOIN followers ON user.id = followers.follower_id and followers.user_id = 4

        // if(!Yii::$app->request->isAjax){
        //     throw new ForbiddenHttpException('Only accessible in ajax request');
        // }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $id ? $id : Yii::$app->user->identity->uuid;
        $cacheKey = 'followers-' . $id . '-limit-' . $limit . '-offset-' . $offset;
        $followers = Yii::$app->cache->get($cacheKey);



        if (!$followers) {
            // $query = (new Query())
            // ->select([
            //     'user.id AS uid',  
            //     'followers2.id as follower_id',               // User ID
            //     'user.username',
            //     // If you need to adjust the profile image path:
            //     new Expression('
            //     CASE 
            //         WHEN `user`.profile_image IS NOT NULL 
            //         THEN CONCAT("'.Yii::getAlias('@web').'/web/", user.profile_image) 
            //         ELSE   CONCAT("'.Yii::getAlias('@web').'","/web/images/profile_img.jpg")
            //     END AS profile_image
            //     '),
            //     'user.bio',
            //     'user.created_at',
            //     'COUNT(DISTINCT followers1.user_id) AS followers_count',  // Counting distinct followers
            //     'COUNT(DISTINCT followers2.user_id) AS following_count',  // Counting distinct following
            // ])
            // ->from('user')  // The main table is `user`
            // ->leftJoin('followers AS followers1', 'followers1.follower_id = user.id')  // Left join for followers count
            // ->leftJoin('followers AS followers2', 'followers2.user_id = user.id')  // Left join for following count
            // ->where(['followers2.follower_id' => $userId])  // Only consider records where followers1.user_id = 4
            // ->groupBy([
            //     'user.id',
            //     'user.username',
            //     'user.profile_image',
            //     'user.bio',
            //     'user.created_at',
            // ]);
            // $followers = $query->all();



            $authUser_uuid = Yii::$app->user->identity->uuid;
            $authUserId = Yii::$app->user->id;

            $profileUser = $this->findUserByUuid($id);
            $profileUserId = $profileUser->id;
            $profileUser_uuid =  $profileUser->uuid;

            $limit = (int)$limit;
            $offset = (int)$offset;

            $sql = "
                SELECT
                    `user`.uuid AS uid,
                    `user`.username,
                    CASE
                        WHEN `user`.uuid=:user2Uuid
                        THEN 1 
                        ELSE 0
                    END AS is_current_user,
                    -- Check if user 3 is following this user (is_follower)
                    CASE 
                        WHEN EXISTS (
                            SELECT 1 
                            FROM followers 
                            WHERE follower_id = `user`.id AND follower_uuid = `user`.uuid AND user_id = :user2Id AND user_uuid = :user2Uuid
                        ) THEN 1
                        ELSE 0 
                    END AS is_follower,
            
                    -- Check if this user is following user 3 (is_following)
                    CASE 
                        WHEN EXISTS (
                            SELECT 1
                            FROM followers 
                            WHERE follower_id =  :user2Id AND follower_uuid = :user2Uuid AND user_id =`user`.id AND user_uuid = `user`.uuid
                        ) THEN 1
                        ELSE 0 
                    END AS is_following,
                    
                    followers2.id AS following_id,
            
                    -- Handle profile image path
                    CASE 
                        WHEN `user`.profile_image IS NOT NULL THEN CONCAT('/web/', `user`.profile_image)  
                        ELSE '/web/images/profile_img.jpg'
                    END AS profile_image,
        
                    `user`.bio,
                    `user`.created_at,
            
                    -- Count distinct followers for this user
                    COUNT(DISTINCT followers1.user_id) AS followers_count,
            
                    -- Count distinct users this user is following
                    COUNT(DISTINCT followers2.user_id) AS following_count
            
                FROM
                    `user`
            
                -- Join to get the followers of the user
                LEFT JOIN followers AS followers1 ON followers1.follower_id = `user`.id 
            
                -- Join to get the following list of user 2 (follower_id = 2)
                LEFT JOIN followers AS followers2 ON followers2.user_id = `user`.id
            
                WHERE
                    followers2.follower_id = :userId  AND  followers2.follower_uuid = :userUuid
            
                GROUP BY
                    `user`.id,
                    `user`.username,
                    `user`.profile_image,
                    `user`.bio,
                    `user`.created_at
                ORDER BY
                    is_current_user DESC
                LIMIT :limit OFFSET :offset;
            ";
            $command = Yii::$app->db->createCommand($sql);
            $command->bindValue(':userId', $profileUserId);
            $command->bindValue(':userUuid', $profileUser_uuid);

            $command->bindValue(':user2Id', $authUserId);
            $command->bindValue(':user2Uuid', $authUser_uuid);



            $command->bindValue(':limit', $limit);
            $command->bindValue(':offset', $offset);

            $followers = $command->queryAll();
            $follower['list'] = $followers;
            $follower['totalFollow'] = count($followers);
            Yii::$app->cache->set($cacheKey, $follower, $this->cacheDuration);
        }

        return $follower;
    }



    public function actionGetfollowing($id, $offset, $limit)
    {

        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = $id ? $id : Yii::$app->user->identity->uuid;
        $cacheKey = 'following-' . $id . '-limit-' . $limit . '-offset-' . $offset;
        $following = Yii::$app->cache->get($cacheKey);


        if (!$following) {
            // $query = new Query();
            // $query->select([
            //     'user.id AS uid',
            //     'followers1.id as following_id',
            //     'user.username',
            //     new Expression('
            //     CASE 
            //         WHEN `user`.profile_image IS NOT NULL 
            //         THEN CONCAT("'.Yii::getAlias('@web').'/web/", user.profile_image) 
            //         ELSE   CONCAT("'.Yii::getAlias('@web').'","/web/images/profile_img.jpg")
            //     END AS profile_image
            //     '),
            //     'user.bio',
            //     'user.created_at',
            //     'COUNT(DISTINCT followers1.user_id) AS followers_count',
            //     'COUNT(DISTINCT followers2.user_id) AS following_count'
            // ])
            // ->from('user')
            // ->leftJoin('followers AS followers1', 'followers1.follower_id = user.id')  // Count users following this user
            // ->leftJoin('followers AS followers2', 'followers2.user_id = user.id')  // Count users this user is following
            // ->where(['followers1.user_id' => $userId])  // Only interested in users where user_id = 2 follows the `user`
            // ->groupBy([
            //     'user.id',
            //     'user.username',
            //     'user.profile_image',
            //     'user.bio',
            //     'user.created_at'
            // ]);


            $authUser_uuid = Yii::$app->user->identity->uuid;
            $authUserId = Yii::$app->user->id;

            $profileUser = $this->findUserByUuid($id);
            $profileUserId = $profileUser->id;
            $profileUser_uuid =  $profileUser->uuid;



            $limit = (int)$limit;
            $offset = (int)$offset;
            $sql = "
                    SELECT
                        `user`.uuid AS uid,
                        `user`.username,
                        CASE
                            WHEN `user`.uuid=:user2Uuid
                            THEN 1 
                            ELSE 0
                        END AS is_current_user,
                        -- Check if user 3 is following this user (is_follower)
                        CASE 
                            WHEN EXISTS (
                                SELECT 1 
                                FROM followers 
                                WHERE  follower_id = `user`.id AND user_id = :user2Id
        
                                AND follower_uuid =  `user`.uuid AND user_uuid = :user2Uuid
        
        
                            ) THEN 1
                            ELSE 0 
                        END AS is_follower,
                
                        -- Check if this user is following user 3 (is_following)
                        CASE 
                            WHEN EXISTS (
                                SELECT 1
                                FROM followers 
                                WHERE  follower_id = :user2Id AND user_id = `user`.id 
        
                                AND follower_uuid =  :user2Uuid AND `user`.uuid
                          
        
                            ) THEN 1
                            ELSE 0 
                        END AS is_following,
                        
                        followers2.id AS following_id,
                
                        -- Handle profile image path
                        CASE 
                            WHEN `user`.profile_image IS NOT NULL THEN CONCAT('/web/', `user`.profile_image)  
                            ELSE '/web/images/profile_img.jpg'
                        END AS profile_image,
        
                        `user`.bio,
                        `user`.created_at,
                
                        -- Count distinct followers for this user
                        COUNT(DISTINCT followers1.user_id) AS followers_count,
                
                        -- Count distinct users this user is following
                        COUNT(DISTINCT followers2.user_id) AS following_count
                
                    FROM
                        `user`
                
                    -- Join to get the followers of the user
                    LEFT JOIN followers AS followers1 ON followers1.follower_id = `user`.id 
                
                    -- Join to get the following list of user 2 (follower_id = 2)
                    LEFT JOIN followers AS followers2 ON followers2.user_id = `user`.id
                
                    WHERE
                        followers1.user_id = :userId AND  followers1.user_uuid = :userUuid 
                
                    GROUP BY
                        `user`.id,
                        `user`.username,
                        `user`.profile_image,
                        `user`.bio,
                        `user`.created_at 
                    ORDER BY
                        is_current_user DESC
        
                    LIMIT :limit OFFSET :offset;
                ";
            $command = Yii::$app->db->createCommand($sql);
            // $command->bindValue(':userId', $id);  
            // $command->bindValue(':user2Id', $authUserId); 

            $command->bindValue(':userId', $profileUserId);
            $command->bindValue(':userUuid', $profileUser_uuid);

            $command->bindValue(':user2Id', $authUserId);
            $command->bindValue(':user2Uuid', $authUser_uuid);


            $command->bindValue(':limit', $limit);
            $command->bindValue(':offset', $offset);



            $followings = $command->queryAll();
            $following['list'] = $followings;
            $following['totalFollow'] = count($followings);
            Yii::$app->cache->set($cacheKey, $following,  $this->cacheDuration);
        }

        return $following;
    }


    public function actionFollowstatus()
    {
        $post = Yii::$app->request->post();
        $followerId = $post['followerId'];
        $authUserUuid = Yii::$app->user->identity->uuid;  // Logged-in user's UUID

        // Prevent following/unfollowing yourself
        if ($authUserUuid == $followerId) {
            return $this->asJson(['success' => false, 'message' => 'Cannot follow/unfollow yourself']);
        }

        // Check if the target user exists using the provided UUID
        $followingUser = $this->findUserByUuid($followerId);
        if (!$followingUser) {
            return $this->asJson([
                'success' => false,
                'message' => 'Requested user not found',
            ]);
        }

        // Check if the user is already following the target user
        $model = Followers::find()->isFollowing($followerId, $authUserUuid)->one();

        if ($model) {
            // If the user is already following, remove the follow
            $model->delete();  

            return $this->asJson([
                'success' => true,
                'is_following' => false,
            ]);
        } else {
            // If the user is not following, create a new follow record
            $model = new Followers();
            $model->follower_id = $followingUser->id;
            $model->user_id = Yii::$app->user->id;  // The logged-in user
            $model->follower_uuid = $followerId;
            $model->user_uuid = $authUserUuid;
            $model->created_at = date('Y:m:d H:i:s');

            // Save the follow record
            if ($model->save()) {
             
                Utility::AddNotification(Yii::$app->user->id, $followingUser->id , null,'follow',null);

                return $this->asJson([
                    'success' => true,
                    'is_following' => true,
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Failed to follow the user.',
                    'errors' => $model->errors,
                ]);
            }
        }
    }



    public function actionRemovefollowing()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }

        $post = Yii::$app->request->post();

        $followingUser = $this->findUserByUuid($post['followingId']);
        // Check if the current user is following the target user
        $exists = Followers::find()->where([
            'follower_id' => $followingUser->id,
            'user_id' => Yii::$app->user->id,

            'follower_uuid' => $post['followingId'],
            'user_uuid' => Yii::$app->user->identity->uuid

        ])->one();

        if ($exists) {
            $model = Followers::deleteAll([
                'follower_id' => $followingUser->id,
                'user_id' => Yii::$app->user->id,

                'follower_uuid' => $post['followingId'],
                'user_uuid' => Yii::$app->user->identity->uuid
            ]);

            $is_following = Followers::find()->where([

                'follower_id' => Yii::$app->user->id,
                'user_id' => $followingUser->id,

                'follower_uuid' => Yii::$app->user->identity->uuid,
                'user_uuid' => $post['followingId']
            ])->exists() ? 1 : 0;

            // Return the response as JSON
            return $this->asJson([
                'success' => true,
                'is_following' => $is_following
            ]);
        }

        return $this->asJson([
            'success' => false,
            'message' => 'You are not following this user.'
        ]);
    }

    public function actionRemovefollower()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }

        $post = Yii::$app->request->post();
        $followerUser = $this->findUserByUuid($post['followerId']);
        $exists =  Followers::find()->where([
            'user_id' => $followerUser->id,
            'user_uuid' => $post['followerId'],

            'follower_id' => Yii::$app->user->id,
            'follower_uuid' => Yii::$app->user->identity->uuid
        ])->exists();

        if ($exists) {
            $model = Followers::deleteAll([
                'user_id' => $followerUser->id,
                'user_uuid' => $post['followerId'],

                'follower_id' => Yii::$app->user->id,
                'follower_uuid' => Yii::$app->user->identity->uuid
            ]);
         

            $is_following = Followers::find()->where([
                'follower_uuid' => $post['followerId'],
                'follower_id' => $followerUser->id,


                'user_id' => Yii::$app->user->id,
                'user_uuid' => Yii::$app->user->identity->uuid
            ])->exists() ? 1 : 0;

            if ($model) {
                return $this->asJson([
                    'success' => true,
                    'is_following' => $is_following
                ]);
            }
        }
    }

    private function findUserByUuid($uuid)
    {
        $user = User::find()->where(['uuid' => $uuid])->one();
        if (!$user) {
            throw new NotFoundHttpException("User not found with UUID: {$uuid}");
        }
        return $user;
    }
}
