<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.03.2018
 * Time: 16:54
 */

namespace app\modules\admin\controllers;

use app\models\Comment;
use yii\web\Controller;
use Yii;

class CommentController extends Controller
{
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy('id desc')->all();

        if (Yii::$app->request->isPost){

            $id = Yii::$app->request->get('id');
            $action = Yii::$app->request->post('action') . "Comment";

            $comment = Comment::findOne($id);

            if ($comment->$action()){
                return $this->redirect(['comment/index']);
            }
        }

        return $this->render('index', [
            'comments' => $comments
        ]);
    }

/*
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if ($comment->delete()){
            return $this->redirect(['comment/index']);
        }
    }

    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);

        if ($comment->allow()){
            return $this->redirect(['comment/index']);
        }
    }

    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);

        if ($comment->disallow()){
            return $this->redirect(['comment/index']);
        }
    }
*/
}