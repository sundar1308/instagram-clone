<?php

namespace app\components;

use Yii;
use DateTime;
use yii\base\Component;
use app\models\Notifications;

class Utility extends Component
{

    public static function getRelativeTime($datetime)
    {
        // Get the current datetime
        $now = new DateTime();

        // Calculate the difference
        $diff = $now->diff($datetime);

        // Determine which format to use based on the difference
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        } elseif ($diff->s > 0) {
            return $diff->s . ' second' . ($diff->s > 1 ? 's' : '') . ' ago';
        } else {
            return 'just now';
        }
    }
    //     // Example usage:
    // $datetime = new DateTime('2024-11-08 08:00:00');
    // echo getRelativeTime($datetime);
    public static function AddNotification($senderUserId, $userId, $postId, $type, $message)
    {
        // Check if the notification already exists (same sender and user)
        $exists = Notifications::find()
            ->where(['user_id' => $userId, 'sender_id' => $senderUserId, 'post_id'=>$postId])
            ->one();
        
        if (!$exists) {
            // Create new notification
            $model = new Notifications();
            $model->user_id = $userId;
            $model->sender_id = $senderUserId;
            $model->post_id = $postId;

    
            // Set the notification message based on the type
            $message = '';
            switch ($type) {
                case 'like':
                    $message = 'liked your post';
                    break;
                case 'follow':
                    $message = 'started following you';
                    break;
                // Add more types here as needed
                default:
                    $message = 'You have a new notification';
            }
    
            $model->type = $type;
            $model->message = $message;
            $model->created_at = new \yii\db\Expression('NOW()');  // Use the database's current timestamp
            $model->read_at = 0;  // Mark as unread by default
            
            // Save the notification and return result
            if ($model->save()) {
                return true;  // Successfully added the notification
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                exit;
                return false; // Failed to save notification
            }
        }
    
        return false; // Notification already exists, no need to create a duplicate
    }
    public static function getNotificationCount(){
        $notificationsCount = Notifications::find()
                ->select('id')  // Select the 'id' column (only for counting purposes)
                ->where([
                    'user_id' => Yii::$app->user->id,  // Only count notifications for the current user
                    'read_at' => 0  // Only count unread notifications
                ])
                ->andWhere([
                    '<>', 'sender_id', Yii::$app->user->id  // Exclude notifications sent by the user
                ])
                ->count();  // Count the number of rows that match the criteria

        return $notificationsCount;
    }


    public static function removeNotification($senderId, $postId, $type){
        Notifications::deleteAll([
            'sender_id' => $senderId,
            'post_id'=>$postId,
            'type'=>$type
        ]);
    }

    // public static function ChangeNotificationStatus($userId){
    //     Notifications::updateAll(
    //         ['read_at' => 1], // Columns to update
    //         ['user_id' => $userId] // Condition
    //     );
    // }

   
}
