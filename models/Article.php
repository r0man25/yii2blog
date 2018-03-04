<?php

namespace app\models;

use app\models\image\ImageUpload;
use Yii;
use app\models\Category;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','category_id'], 'required'],
            [['title','description','content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['category_id'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['image'], 'safe'],
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
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }


    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }


    public function getCategoryTitle()
    {
        if ($this->category){
            return $this->category->title;
        }
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUsername()
    {
        if ($this->user){
            return 'ID: ' . $this->user->id . '; User name: ' . $this->user->username;
        }
    }

    public function getUsernameForSite()
    {
        if ($this->user){
            return $this->user->username;
        }
        return "No-name";
    }


    public function getTags()
    {
        return $this->hasMany(Tag::className(),['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTagsIds()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }


    public function getSelectedTags()
    {
        return $selectedTitle = $this->getTags()->all();
    }

    public static function getArticlesByCategory($id)
    {
        return $query = Article::find()->where(['category_id' => $id])->all();
    }


    public function saveTags($tags)
    {
        if (is_array($tags)){

            $this->clearCurrentTags();

            foreach ($tags as $tag_id){
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
    }


    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }



    public static function getArticleWithPagination($articleLimit = 4)
    {
        $query = Article::find();
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

    public static function getPopolarArticle()
    {
        return Article::find()->orderBy('viewed desc')->limit(3)->all();
    }


    public static function getRecentArticle()
    {
        return Article::find()->orderBy('date desc')->limit(4)->all();
    }

    public static function getPreviousArticle($id)
    {
        return Article::find()->where("id < $id")->orderBy('id desc')->one();
    }

    public static function getNextArticle($id)
    {
        return Article::find()->where("id > $id")->one();
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(),['article_id' => 'id']);
    }

    public function getArticleComments()
    {
        return $this->getComments()->where(['status' => 1])->orderBy('id desc')->all();
    }


    public function viewedCounter()
    {
        $this->viewed++;
        return $this->save(false);
    }

}
