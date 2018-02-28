<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\image\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $article = Article::find()->all();

        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $imageUploadModel = new ImageUpload();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'imageUploadModel' => $imageUploadModel,
        ]);
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload();

        if (Yii::$app->request->isPost){
            $article = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');

            if ($article->saveImage($model->uploadFile($file, $article->image))){
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
//        return $this->render('image',[
//            'model' => $model,
//        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $imageModelUpload = new ImageUpload();
        
        $categories = Category::find()->asArray()->all();
        $categories = ArrayHelper::map($categories, 'id', 'title');

        $tags = ArrayHelper::map(Tag::find()->all(),'id', 'title');
        $selectedTags = [];

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($imageModelUpload, 'image');
            $model->image =  $imageModelUpload->uploadFile($file);

            if ($model->save()){
                $tags = Yii::$app->request->post('tags');
                $model->saveTags($tags);
                return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imageModelUpload = new ImageUpload();

        $categories = Category::find()->asArray()->all();
        $categories = ArrayHelper::map($categories, 'id', 'title');

        $tags = ArrayHelper::map(Tag::find()->all(),'id', 'title');
        $selectedTags = $model->getSelectedTags();

        if ($model->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($imageModelUpload, 'image');
            $model->image = $imageModelUpload->uploadFile($file, $model->image);

            if ($model->save()){
                $tags = Yii::$app->request->post('tags');
                $model->saveTags($tags);
                return $this->redirect(['view', 'id' => $model->id]);
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

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionSetTags($id)
    {
        $article = $this->findModel($id);

        $selectedTags = $article->getSelectedTags();

        $tags = ArrayHelper::map(Tag::find()->all(),'id', 'title');

        if (Yii::$app->request->isPost){
            $tags = Yii::$app->request->post('tags');
            $article->saveTags($tags);
            $this->redirect(['view', 'id' => $article->id]);
        }

        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => $tags,
        ]);
    }

}
