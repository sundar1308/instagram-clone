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
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class PostsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['fetchposts', 'create'],  // Allow all actions
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
    public function actionIndex()
    {
        // return $this->render('_create_model',[

        // ])
    }
    public function actionCreate()
    {
        $model = new Posts();

        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Method not allowed');
        }
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image_path');
            $path = 'post/images/' . Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
            $filePath = Yii::getAlias('@webroot/web/' . $path);
            if ($file) {
                $directoryPath = dirname($filePath);
                if (!is_dir($directoryPath)) {
                    FileHelper::createDirectory($directoryPath);  // Pass correct permissions here
                }

                // echo "<pre>";
                // print_r($filePath);
                // exit;
                $file->saveAs($filePath);
            }
            $model->image_path = $path;
            $model->user_id = Yii::$app->user->id;
            $model->user_uuid = Yii::$app->user->identity->uuid;
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->getErrors()
                ]);
            }
        }
    }

    // Controller action to fetch posts
    public function actionFetchposts($offset = 0, $limit = 5)
    {
        // Get posts with offset and limit for pagination
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException('Only accessible in ajax request');
        }
        $posts = Posts::find()
            ->offset($offset)
            ->limit($limit)->orderBy([
                'created_at' => SORT_DESC
            ])
            ->all();

        // Render the posts as partial view
        return $this->renderAjax('_post', [
            'posts' => $posts,
        ]);
    }
}
