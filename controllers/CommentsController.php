<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Posts;
use yii\web\Response;
use yii\web\Controller;
use app\models\Comments;
use yii\bootstrap5\Html;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use app\models\CommentLikes;
use DateTime;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class CommentsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['fetchposts', 'getcomments', 'addcomment', 'likecomment'],
                'rules' => [
                    [
                        'actions' => ['fetchposts', 'getcomments', 'addcomment', 'likecomment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }

    public function actionGetcomments($postId)
    {

        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }
        $cacheKey = Comments::All_Comments . $postId;


        $commentsData =  Yii::$app->cache->get($cacheKey);

        if (!$commentsData) {
            // Get top-level comments for a post
            $comments = Comments::find()
                ->where(['post_uuid' => $postId, 'parent_comment_id' => null])
                ->all();

            $commentsData = [];

            foreach ($comments as $comment) {
                $commentData = [
                    'id' => $comment->uuid,
                    'post_id' => $postId,
                    'profile_image' => $comment->user->getProfileImage(),
                    'username' => $comment->user->username, // assuming the `user` relation exists
                    'content' => $comment->content,
                    'like_status' => $comment->getLikes()->where([
                        'user_id' => Yii::$app->user->id,
                        'comment_id' => $comment->id
                    ])->one(),
                    'likes_count' => $comment->getLikes()->count(),
                    'created_at' => Yii::$app->formatter->asRelativeTime(strtotime($comment->created_at)),
                    'replies' => [],
                ];

                // Fetch replies (child comments) for each comment
                $replies = Comments::find()->where(['parent_comment_id' => $comment->id])->all();
                foreach ($replies as $reply) {
                    $commentData['replies'][] = [
                        'id' => $reply->uuid,
                        'username' => $reply->user->username,
                        'content' => $reply->content,
                        'like_status' => $reply->getLikes()->where([
                            'user_id' => Yii::$app->user->id,
                            'comment_id' => $reply->id
                        ])->one(),
                        'likes_count' => $reply->getLikes()->count(),
                        'profile_image' => $reply->user->getProfileImage(),
                        'created_at' => Yii::$app->formatter->asRelativeTime($reply->created_at),

                    ];
                }
                // Add to the comments array
                $commentsData[] = $commentData;
            }
            Yii::$app->cache->set($cacheKey, $commentsData, 5);
        }

        return $this->asJson($commentsData);
    }




    public function actionAddcomment()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $postId = Yii::$app->request->post('postId');
        $commentText = Yii::$app->request->post('comment');
        $userId = Yii::$app->user->id;
        $parentId = Yii::$app->request->post('parentId');

        // Validate the data (you can add more validation rules)
        if (empty($commentText) || empty($postId) || empty($userId)) {
            return ['success' => false, 'message' => 'Invalid data'];
        }

        // Create the new comment

        $post_id = Posts::find()->select('id')->where(['uuid' => $postId])->one();

        // echo "<pre>";
        // print_r(Yii::$app->request->post());
        // exit;

        $comment = new Comments();
        $comment->user_id = $userId;
        $comment->post_id = $post_id->id;
        $comment->post_uuid = $postId;
        $comment->user_uuid =  Yii::$app->user->identity->uuid;
        $comment->content = Html::encode($commentText);  // Escape content to prevent XSS
        $comment->created_at = date('Y-m-d H:i:s');
        // $comment->parent_comment_id = $parentId; // Set parent if it's a reply

        if ($parentId) {
            $parentComment = Comments::findOne(['uuid' => $parentId]); // Find parent comment by UUID
            if ($parentComment) {
                $comment->parent_comment_id = $parentComment->id; // Set the integer ID of the parent comment
            } else {
                // Handle the case where the parent comment is not found, maybe set to NULL or handle error
                $comment->parent_comment_id = null;
            }
        } else {
            $comment->parent_comment_id = null; // No parent, so set to NULL
        }

        $comment->created_at = date('Y-m-d H:i:s');  // Corrected function to set the timestamp


        if ($comment->save()) {
            // Prepare the response with the new comment data
            $response = [
                'success' => true,
                'comment' => [
                    'id' => $comment->uuid,
                    'post_id' => $postId,
                    'username' => $comment->user->username,  // Assuming a relation `user` exists
                    'content' => $comment->content,
                    'created_at' => Yii::$app->formatter->asRelativeTime(strtotime($comment->created_at)),
                    'profile_image' => $comment->user->getAuthUserProfileImage(),  // Add a method to get the user's profile image
                    'like_status' => $comment->getLikes()->where([
                        'user_id' => Yii::$app->user->id,
                        'comment_id' => $comment->id
                    ])->one(),
                    'likes_count' => $comment->getLikes()->count(),
                ]
            ];
            return $this->asJson($response);
        } else {

            // echo "<pre>";
            // print_r($comment->getErrors());
            // exit;

            return $this->asJson(['success' => false, 'message' => 'Failed to save comment']);
        }
    }


    public function actionLikeComment()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }
        if (Yii::$app->request->isAjax) {
            // Retrieve comment UUID and logged-in user's UUID
            $commentUuid = Yii::$app->request->post('commentId');  // comment UUID from the request
            $userUuid = Yii::$app->user->identity->uuid;  // Logged-in user's UUID

            // Check if the user has already liked this comment using UUIDs
            $existingLike = $this->findCommentByUuid($commentUuid, $userUuid);

            if ($existingLike) {
                // User has already liked, so we remove the like
                $existingLike->delete();
                $response = [
                    'status' => 'success',
                    'message' => 'Like removed',
                    'likeStatus' => 0,
                    'likeCount' => $this->getCommentLikeCount($commentUuid),  // Update like count based on comment UUID
                ];
            } else {
                // Add a new like if not already liked
                $comment = Comments::find()
                    ->where(['uuid' => $commentUuid])  // Find the comment by UUID
                    ->one();

                if ($comment) {
                    $like = new CommentLikes();
                    $like->comment_id = $comment->id;  // Use the comment's UUID
                    $like->user_id = Yii::$app->user->id;          // Use the logged-in user's UUID

                    $like->comment_uuid = $comment->uuid;  // Use the comment's UUID
                    $like->user_uuid = $userUuid;          // Use the logged-in user's UUID

                    if ($like->save()) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Liked successfully',
                            'likeStatus' => 1,
                            'likeCount' => $this->getCommentLikeCount($commentUuid),  // Update like count based on comment UUID
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => $like->getErrors(),
                        ];
                    }
                } else {
                    // Comment not found, return error response
                    $response = [
                        'status' => 'error',
                        'message' => 'Comment not found.',
                    ];
                }
            }

            // Return the response as JSON
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $response;
        }
        return $this->goBack();
    }

    // Helper method to get the like count of a comment
    private function getCommentLikeCount($commentId)
    {
        return CommentLikes::find()->where(['comment_id' => $commentId])->count();
    }


    // Find comment like by UUID (comment_uuid, user_uuid)
    private function findCommentByUuid($commentUuid, $userUuid)
    {
        return CommentLikes::find()
            ->where(['comment_uuid' => $commentUuid, 'user_uuid' => $userUuid])
            ->one();
    }

    // Function to check if the user has already liked the post (using UUID)
    private function hasUserLikedPost($postUuid, $userUuid)
    {
        return CommentLikes::find()
            ->where(['post_uuid' => $postUuid, 'user_uuid' => $userUuid])
            ->exists();
    }
}
