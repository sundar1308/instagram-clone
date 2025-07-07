<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use app\models\User;
use app\models\Likes;
use app\models\Posts;
use yii\db\Expression;
use yii\web\Controller;
use app\models\Followers;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\db\conditions\LikeCondition;

class ProfileController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'edit', 'view'],  // Allow all actions
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
        $model = Yii::$app->user->identity;
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        $model = User::find()->where([
            'uuid' => $id
        ])->one();
        if ($model) {
            return $this->render('index', [
                'model' => $model
            ]);
        } else {
            return $this->redirect(['site/index']);
        }
    }

    public function actionEdit()
    {
        $userId = Yii::$app->user->id;
        $model =  User::find()->where([
            'id' => $userId,
        ])->one();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'profile_image');
            $path = 'profile/images/' . Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
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
            $post = Yii::$app->request->post('User');
            $model->profile_image = $path;

            $model->bio = json_encode(
                [
                    'nick_name' => $post['nick_name'],
                    'desc' => $post['desc']
                ]
            );

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }
}
