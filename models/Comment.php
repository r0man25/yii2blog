<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property int $article_id
 * @property int $status
 * @property string $date
 *
 * @property Article $article
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    const STATUS_ALL0W = 1;
    const STATUS_DISALL0W = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'article_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'user_id' => 'User ID',
            'article_id' => 'Article ID',
            'status' => 'Status',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPhoto()
    {
        return ($this->user->photo) ? '/uploads/' . $this->user->photo : '/no-image.png';
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public function isAllowed()
    {
        return $this->status;
    }

    public function allowComment()
    {
        $this->status = self::STATUS_ALL0W;
        return $this->save(false);
    }

    public function disallowComment()
    {
        $this->status = self::STATUS_DISALL0W;
        return $this->save(false);
    }


    public function deleteComment()
    {
        return $this->delete();
    }
}
