<?php
/**
 * Created by PhpStorm.
 * User: us10140
 * Date: 02.03.2018
 * Time: 12:20
 */

namespace app\models\forms;

use app\models\image\ImageUpload;
use yii\web\UploadedFile;
use app\models\User;
use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $photo;

    public function __construct()
    {
        $this->photo = new ImageUpload();
    }

    public function rules()
    {
        return [

            [['username'], 'trim'],
            [['username'], 'required'],
            [['username'], 'string', 'min' => 2, 'max' => 255],
            [['username'], 'unique', 'targetClass' => User::className()],

            [['email'], 'trim'],
            [['email'], 'required'],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique', 'targetClass' => User::className()],

            [['password'], 'required'],
            [['password'], 'string', 'min' => 6],

        ];
    }

    public function createUser()
    {
        $file = UploadedFile::getInstance($this->photo, 'image');

        if ($this->validate()) {
            $user = new User();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->created_at = $time = time();
            $user->updated_at = time();
            $user->photo = $this->photo->uploadFile($file);


            if ($user->save()) {
                return $user;
            }
        }
    }

}