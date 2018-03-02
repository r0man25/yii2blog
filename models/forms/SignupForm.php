<?php
/**
 * Created by PhpStorm.
 * User: us10140
 * Date: 02.03.2018
 * Time: 12:20
 */

namespace app\models\forms;

use app\models\User;
use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            [['username'], 'unique', 'targetClass' => User::className()],
            [['email'], 'unique', 'targetClass' => User::className()],
            [['username'], 'string', 'min' => 3],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6],
        ];
    }

    public function login()
    {
        if ($this->validate()){
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->created_at = $time = time();
            $user->updated_at = time();
        }

        if ($user->save()){
            return $user;
        }

    }

}