<?php
/**
 * Created by PhpStorm.
 * User: us10140
 * Date: 02.03.2018
 * Time: 11:29
 */

namespace app\controllers;

use app\models\forms\SignupForm;
use yii\web\Controller;
use app\models\forms\LoginForm;
use Yii;

class UserController extends Controller
{

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $user = $model->createUser()){
            Yii::$app->user->login($user);
            Yii::$app->session->setFlash('success', 'Register success!');
            return $this->redirect(['site/index']);
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('info', "Hello $model->username!");
            return $this->redirect(['site/index']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }



}