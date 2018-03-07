<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property ArticleTag[] $articleTags
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(),['id' => 'article_id'])
            ->viaTable('article_tag', ['tag_id' => 'id']);
    }

    public static function getArticlesByTagWithPagination($id, $articleLimit = 3)
    {
        $query = Tag::findOne($id)->getArticles();
        $countQuery = $query->count();

        $pagination = new Pagination(['totalCount' => $countQuery, 'pageSize' => $articleLimit]);
        $articles = $query->offset($pagination->offset)
            ->orderBy('id desc')
            ->limit($pagination->limit)
            ->all();

        $data['articles'] = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }


    public static function getAllTags()
    {
        return Tag::find()->all();
    }


    public function getArticleCountByTag()
    {
        return $this->getArticles()->count();
    }

    public static function getTagsAsArray()
    {
        return ArrayHelper::map(Tag::find()->all(),'id', 'title');
    }
}
