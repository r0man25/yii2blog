<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\User;
use Yii;

class LoginForm extends Model
{
    public $username;
    public $password;

    private $_username = false;

    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['username'], 'required'],

            [['password'], 'required'],
            [['password'], 'validatePassword'],
        ];
    }

    public function login()
    {
        if ($this->validate()){
            return Yii::$app->user->login($this->getUser());
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()){
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)){
                $this->addError($attribute,'Incorrect password');
            }
        }

    }

    public function getUser()
    {
        if ($this->_username === false){
            $this->_username = User::findUserByUsername($this->username);
        }
        return $this->_username;
    }
}