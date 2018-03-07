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

class UpdateUserForm extends Model
{
    public $username;
    public $email;
    public $isAdmin;
    public $photo;
    public $_username;
    public $_email;

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

            [['isAdmin'], 'integer'],
            [['isAdmin'], 'in', 'range' => [0,1]],

        ];
    }

    public function getUserById($id)
    {
        $user = User::findOne($id);

        $this->username = $user->username;
        $this->email = $user->email;
        $this->isAdmin = $user->isAdmin;
        $this->_username = $user->username;
        $this->_email = $user->email;
    }


    public function updateUser($id)
    {
        $file = UploadedFile::getInstance($this->photo, 'image');

        $user = User::findOne($id);

        $user->email = '';
        $user->username = '';
        $user->update();

        if ($this->validate()) {
            $user->username = $this->username;
            $user->email = $this->email;
            $user->updated_at = time();
            if($file) {
                $user->photo = $this->photo->uploadFile($file);
            }
            $user->isAdmin = $this->isAdmin;

            if ($user->save()) {
                return true;
            }
        }

        $user->email = $this->_email;
        $user->username = $this->_username;
        $user->update();
    }
}