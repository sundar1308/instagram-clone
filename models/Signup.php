<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class Signup extends Model
{
    public $email;
    public $username;
    public $password;

    public function saveUser(){
        // print_r($this);
        // exit;
        $user = new User();
        $user->email = $this->email;
        $user->username = $this->username;
        $user->password_hash =Yii::$app->security->generatePasswordHash($this->password);
        if($user->save(false)){
            return true;
        }
    }

}