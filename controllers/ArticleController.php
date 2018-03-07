<?php
/**
 * Created by PhpStorm.
 * User: us10140
 * Date: 06.03.2018
 * Time: 15:01
 */

namespace app\controllers;

use app\models\Tag;
use yii\web\Controller;
use app\models\Article;
use app\models\Category;
use app\models\image\ImageUpload;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;

class ArticleController extends Controller
{

    public function behaviors()
    {
        return [
            'access'    =>  [
                'class' =>  AccessControl::className(),
                'denyCallback'  =>  function($rule, $action)
                {
                    throw new \yii\web\NotFoundHttpException();
                },
                'rules' =>  [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->checkUser();
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'matchCallback' => function ($rule, $action) {
                            return $this->checkUser();
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'matchCallback' => function ($rule, $action) {
                            $model = $this->findModel(Yii::$app->getRequest()->get('id'));
                            return Yii::$app->user->can('updatePost', ['post' => $model]);
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'matchCallback' => function ($rule, $action) {
                            $model = $this->findModel(Yii::$app->getRequest()->get('id'));
                            return Yii::$app->user->can('deletePost', ['post' => $model]);
                        }
                    ],
                ]
            ]
        ];
    }

    protected function checkUser()
    {
        if (isset(Yii::$app->user->identity)){
            return Yii::$app->user->id;
        }
        return false;
    }

    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionIndex()
    {
        $articles = Article::getArticlesByUser(Yii::$app->user->id);

        return $this->render('index', [
            'articles' => $articles
        ]);
    }


    public function actionCreate()
    {
        $model = new Article();
        $imageModelUpload = new ImageUpload();

        $categories = Category::getCategoriesAsArray();

        $tags = Tag::getTagsAsArray();
        $selectedTags = [];

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($imageModelUpload, 'image');
            $model->image =  $imageModelUpload->uploadFile($file);
            $model->user_id = Yii::$app->user->id;

            if ($model->save()){
                $tags = Yii::$app->request->post('tags');
                $model->saveTags($tags);
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'imageModelUpload' => $imageModelUpload,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = Article::findOne($id);
        $imageModelUpload = new ImageUpload();

        $categories = Category::getCategoriesAsArray();

        $tags = Tag::getTagsAsArray();
        $selectedTags = $model->getSelectedTagsIds();

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($imageModelUpload, 'image');
            $model->image = $imageModelUpload->uploadFile($file, $model->image);
            $model->user_id = Yii::$app->user->id;

            if ($model->save()){
                $tags = Yii::$app->request->post('tags');
                $model->saveTags($tags);
                return $this->redirect(['article/index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'imageModelUpload' => $imageModelUpload,
            'categories' => $categories,
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ]);
    }


    public function actionDelete($id)
    {
        Article::findOne($id)->delete();

        return $this->redirect(['article/index']);
    }

}