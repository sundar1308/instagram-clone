<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\components\Utility;
use app\models\Notifications;
use yii\filters\AccessControl;

class NotificationController extends Controller
{
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::class,
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'actions' => ['addnotification'],  // Allow all actions
    //                     'roles' => ['@'],    // Authenticated users (logged in)
    //                 ],
    //                 [
    //                     'allow' => false, // Deny access for guests (not authenticated users)
    //                     'roles' => ['?'],  // Guests (not logged in)
    //                 ],
    //             ],
    //         ],
    //     ];
    // }
     public function actionGetusernotifications()
    {
       $notifications =  Notifications::find()->where([
            'user_id'=>Yii::$app->user->id
        ])->andWhere([
            '<>', 'sender_id', Yii::$app->user->id
        ])->all();
        $response = [];
        foreach ($notifications as  $notification) {
                $response[] = [
                    'username'=>$notification->sender->username,
                    // 'profile_image'=> Yii::getAlias('@web/web'.$notification->sender->profile_image),
                    'profile_image'=> $notification->sender->getProfileImage(),
                    'profile_url'=> Url::to(['/profile/view', 'id'=>$notification->sender->uuid]),
                    'type'=>$notification->type,
                    'message'=>$notification->message,
                    'post_image'=>$notification->post_id?Yii::getAlias('@web/web/'.$notification->post->image_path):null,
                    'created_at'=>Yii::$app->formatter->asRelativeTime($notification->created_at),
                ];
        }
        // echo "<pre>";
        // print_r($response );
        // exit;
        return $this->asJson(['notification'=>$response]);
    }
    public function actionChangenotificationstatus()
    {
        // Utility::ChangeNotificationStatus(Yii::$app->user->id);
        Notifications::updateAll(
            ['read_at' => 1], // Columns to update
            ['user_id' => Yii::$app->user->id] // Condition
        );
        return $this->asJson([
            'success'=>true,

        ]);
    }
    

}