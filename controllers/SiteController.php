<?php

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\forms\CommentForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Article;
use app\models\Tag;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $articlesWithPagination = Article::getArticleWithPagination();

        $popular = Article::getPopolarArticle();
        
        $recent = Article::getRecentArticle();

        $categories = Category::getAllCategories();
        $tags = Tag::getAllTags();


        return $this->render('index', [
            'articles' => $articlesWithPagination['articles'],
            'pagination' => $articlesWithPagination['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }




    public function actionView($id)
    {
        $article = Article::findOne($id);

        $prevArticle = Article::getPreviousArticle($id);
        $nextArticle = Article::getNextArticle($id);

        $categoryArticles = Article::getArticlesByCategory($article->category_id);

        $popular = Article::getPopolarArticle();
        $recent = Article::getRecentArticle();
        $categories = Category::getAllCategories();
        
        $selectedTags = $article->getSelectedTags();

        $tags = Tag::getAllTags();

        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();

        $article->viewedCounter();

        return $this->render('single',[
            'article' => $article,
            'prevArticle' => $prevArticle,
            'nextArticle' => $nextArticle,
            'categoryArticles' => $categoryArticles,
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'selectedTags' => $selectedTags,
            'tags' => $tags,
            'comments' => $comments,
            'commentForm' => $commentForm,
        ]);
    }


    public function actionComment($id)
    {
        $model = new CommentForm();
        if ($model->load(Yii::$app->request->post()) && $model->saveComment($id)){
            Yii::$app->session->setFlash('success', 'Your comment will be added soon.');
            return $this->redirect(['site/view', 'id' => $id]);
        }
    }



    public function actionCategory($id)
    {
        $articlesWithPagination = Category::getArticlesByCategoryWithPagination($id);
        $popular = Article::getPopolarArticle();
        $recent = Article::getRecentArticle();
        $categories = Category::getAllCategories();
        $tags = Tag::getAllTags();

        $requestId = Yii::$app->request->get('id');
        $requestAction = Yii::$app->controller->action->id;

        return $this->render('category', [
            'articles' => $articlesWithPagination['articles'],
            'pagination' => $articlesWithPagination['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'tags' => $tags,
            'requestId' => $requestId,
            'requestAction' => $requestAction,
        ]);
    }

    public function actionTag($id)
    {

        $articlesWithPagination = Tag::getArticlesByTagWithPagination($id);

        $popular = Article::getPopolarArticle();
        $recent = Article::getRecentArticle();
        $categories = Category::getAllCategories();
        $tags = Tag::getAllTags();

        $requestId = Yii::$app->request->get('id');
        $requestAction = Yii::$app->controller->action->id;

        return $this->render('tag', [
            'articles' => $articlesWithPagination['articles'],
            'pagination' => $articlesWithPagination['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'categories' => $categories,
            'tags' => $tags,
            'requestId' => $requestId,
            'requestAction' => $requestAction,
        ]);
    }
}
