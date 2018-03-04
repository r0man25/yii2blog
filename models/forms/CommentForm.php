<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04.03.2018
 * Time: 12:37
 */

namespace app\models\forms;

use app\models\Comment;
use yii\base\Model;
use Yii;


class CommentForm extends Model
{
    public $comment;

    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3,250]]
        ];
    }

    public function saveComment($article_id)
    {
        if ($this->validate()){
            $comment = new Comment();

            $comment->text = $this->comment;
            $comment->article_id = $article_id;
            $comment->user_id = Yii::$app->user->id;
            $comment->status = 0;
            $comment->date = date('Y-m-d');

            return $comment->save();
        }
    }
}