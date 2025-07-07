<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Likes;
use app\models\Posts;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\components\Utility;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\db\conditions\LikeCondition;

class LikeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['changestatus'],  // Allow all actions
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
    public function actionChangestatus()
    {
        // Get data from the request
        $post = Yii::$app->request->post();
        $userId = Yii::$app->user->identity->uuid;
    
        // Find the post by UUID
        $postModel = $this->findPostByUuid($post['postId']);
        if ($postModel === null) {
            return $this->asJson([
                'success' => false,
                'message' => 'Post not found.'
            ]);
        }
    
        // Check if the user has already liked this post
        $existingLike = $this->hasUserLikedPost($postModel->id, Yii::$app->user->id);
        
        if ($existingLike) {
            // User already liked the post, so remove the like
            Likes::deleteAll([
                'user_id' => Yii::$app->user->id,
                'post_id' => $postModel->id,
            ]);
            $type="like";
            Utility::removeNotification( Yii::$app->user->id, $postModel->id, $type);
            
            return $this->asJson([
                'success' => true,
                'message' => 'Like removed successfully.',
            ]);
        } else {
            // User has not liked the post, so add the like
            $model = new Likes();
            $model->post_id = $postModel->id;
            $model->post_uuid = $postModel->uuid;
            $model->user_id = Yii::$app->user->id;
            $model->user_uuid = $userId;
        
            // Save the like
            if ($model->save()) {
                $message = Yii::t('app', '{username} started following you.', [
                    'username' => Yii::$app->user->identity->username,
                ]);
            Utility::AddNotification(Yii::$app->user->id, $postModel->user_id, $postModel->id,'like', $message);
                
                return $this->asJson([
                    'success' => true,
                    'message' => 'Like added successfully.',
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'message' => 'Failed to add like.',
                    'errors' => $model->getErrors(),
                ]);
            }
        }
    }
    

    // Function to check if post exists
    private function findPostByUuid($uuid)
    {
        return Posts::find()->where(['uuid' => $uuid])->one();
    }

    // Function to check if the user has already liked the post
    private function hasUserLikedPost($postId, $userId)
    {
        return Likes::find()->where(['post_id' => $postId, 'user_id' => $userId])->one();
    }
}
