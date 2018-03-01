<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
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


    public function getArticle()
    {
        return $this->hasMany(Article::className(),['category_id' => 'id']);
    }

    public static function getAllCategories()
    {
        return Category::find()->all();
    }

    public function getArticleCountByCatrgory()
    {
        return $this->getArticle()->count();
    }

    public static function getArticlesByCategoryWithPagination($id, $articleLimit = 3)
    {
        $query = Article::find()->where(['category_id' => $id]);
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



}
