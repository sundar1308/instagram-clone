<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\Response;
use app\models\Message;
use yii\web\Controller;
use app\models\Messages;
use yii\web\NotFoundHttpException;

class MessageController extends Controller
{
    // Send a message
    public function actionSend($receiverId, $messageText)
    {
        $senderId = Yii::$app->user->id;
        
        if ($senderId == $receiverId) {
            throw new NotFoundHttpException("You can't send messages to yourself.");
        }

        $message = new Messages();
        $message->sender_id = $senderId;
        $message->receiver_id = $receiverId;
        $message->content = $messageText;
        
        if ($message->save()) {
            // Optionally update conversation table here
            
            // For real-time update, trigger an event or use WebSockets
            return $this->asJson(['success' => true, 'message' => $message]);
        }

        return $this->asJson(['success' => false, 'errors' => $message->errors]);
    }

    // Get conversation
    public function actionGetConversation($userId)
    {
        $currentUserId = Yii::$app->user->id;

        if ($currentUserId == $userId) {
            throw new NotFoundHttpException("Invalid request.");
        }

        $messages = Messages::find()
        ->where(['or', 
            ['sender_id' => $currentUserId, 'receiver_id' => $userId], 
            ['sender_id' => $userId, 'receiver_id' => $currentUserId]
        ])
        ->orderBy(['created_at' => SORT_ASC])
        ->all();
            // print_r($messages);
            // exit;
        return $this->render('conversation', ['messages' => $messages, 'userId' => $userId]);
    }
    
    public function actionConversations(){
        
        return $this->render('conversation', ['friends'=>User::find()->all()]);
        
    }
    // Mark message as read
    public function actionMarkAsRead($messageId)
    {
        $message = Messages::findOne($messageId);
        
        if ($message && $message->receiver_id == Yii::$app->user->id) {
            $message->status = 'read';
            $message->save();
        }

        return $this->asJson(['success' => true]);
    }
}